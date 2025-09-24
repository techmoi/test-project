<?php
namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Mail\MyMail;

use Hashids\Hashids;

use App\Models\Admin\EmailTemplate;
use App\Models\Admin\EmailLog;

use App\Libraries\SendGrid;

class General
{
	/** 
	* To make random hash string
	*/	
	public static function hash($limit = 32)
	{
		return Str::random($limit);
	}

	/** 
	* To make random number
	*/	
	public static function randomNumber($limit = 8)
	{
		$characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $limit; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	/** 
	* To encrypt
	*/
	public static function encrypt($string)
	{
		return Crypt::encryptString($string);
	}

	/** 
	* To decrypt
	*/
	public static function decrypt($string)
	{
		return Crypt::decryptString($string);
	}

	/** 
	* To encode
	*/
	public static function encode($string)
	{
		$hashids = new Hashids(config('app.key'), 6);
		return $hashids->encode($string);
	}

	/** 
	* To decode
	*/
	public static function decode($string)
	{
		$hashids = new Hashids(config('app.key'), 6);
		return current($hashids->decode($string));
	}

	/** 
	* Url to Anchor Tag
	* @param 
	*/
	public static function urlToAnchor($url)
	{
		return '<a href="' . $url . '" target="_blank">'.$url.'</a>';
	}

	/**
	* To validate the captcha
	* @param $token 
	**/
	public static function validateReCaptcha($token)
	{
		$data = [
			'secret' => config('constant.recaptcha_secret'),
			'response' => $token,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$response = Http::asForm()
			->post(
				'https://www.google.com/recaptcha/api/siteverify',
				$data
			);
			
		return $response->successful() && $response->json() && isset($response->json()['success']) && $response->json()['success'];
	}

	/**
	* To send template email
	**/
	public static function sendTemplateEmail($to, $template, $shortCodes = [], $attachments = [], $cc = null, $bcc = null)
	{	
		$template = EmailTemplate::getRow([
				'slug LIKE ?', [$template]
			]);

		if($template)
		{
			$shortCodes = array_merge($shortCodes, [
				'{company_name}' => config('constant.company_name'),
				'{admin_link}' => General::urlToAnchor(url('/admin')),
				'{website_link}' => General::urlToAnchor(url('/'))
			]);
			$subject = $template->subject;
			$message = $template->description;
			$subject = str_replace (
				array_keys($shortCodes), 
				array_values($shortCodes), 
				$subject
			);

			$message = str_replace (
				array_keys($shortCodes), 
				array_values($shortCodes), 
				$message
			);

			return General::sendEmail(
				$to,
				$subject,
				$message,
				$cc,
				$bcc,
				$attachments,
				$template->slug
			);
		}
		else
		{
			throw new \Exception("Tempalte could be found.", 500);
		}
	}

	/**
	* To send email
	**/
	public static function sendEmail($to, $subject, $message, $cc = null, $bcc = null, $attachments = [], $slug = null, $from = null, $username = null)
	{
		$from = $from ? $from : config('constant.from_email');
		$emailMethod = config('constant.email_method');

		// Block Email Addresses
		$blockEmailDomains = config('constant.block_email_domains');

		$sent = false;

		if($blockEmailDomains)
		{
			if($to && is_array($to))
			{
				foreach ($to as $key => $toValue)
				{
					$array =  explode(',', $blockEmailDomains);	
					$check = explode('@', $toValue);		

					if(in_array($check[1],$array))
					{
						unset($to[$key]);
					}	
				}
				$to = array_values($to);

				if (count($to) < 1) 
				{
					return true;	
				}
			}
			else
			{
				$array =  explode(',', $blockEmailDomains);	
				$check = explode('@', $to);		

				if(in_array($check[1],$array))
				{
					return true;
				}
			}
		}

		$log = EmailLog::create([
			'slug' => $slug,
			'subject' => $subject,
			'description' => $message,
			'from' => $from,
			'to' => $to && is_array($to) ? json_encode($to) : $to,
			'cc' => $cc && is_array($cc) ? json_encode($cc) : $cc,
			'bcc' => $bcc,
			'open' => 0,
			'sent' => 0
		]);

		if($log)
		{	
			if($emailMethod == 'smtp')
			{

				//$company = config('constant.company_name');

				if(isset($username) && $username)
				{
					$company = $username;
				}
				else
				{
					$company = 'Globiz Technology';
				}
				
				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/
				$password = config('constant.smtp_password');
				
				//$password = $password ? General::decrypt($password) : "";
				
				config([
					'mail.mailers.smtp.host' => config('constant.smtp_host'),
					'mail.mailers.smtp.port' => config('constant.smtp_port'),
					'mail.mailers.smtp.encryption' => config('constant.smtp_encryption'),
					'mail.mailers.smtp.username' => config('constant.smtp_username'),
					'mail.mailers.smtp.password' => $password,
				]);
				/** OVERWRITE SMTP SETTIGS AS WE HAVE IN DB. CHECK config/mail.php **/

				$mail = Mail::mailer('smtp')
					->to($to);

				if($cc)
				{
				    if(is_array($cc))
				    {
				        $mail->cc($cc);
				    }
				    else
				    {
				    	$mail->cc($cc);
				    }
			    }

				/*if($cc)
					$mail->cc($cc);*/
				if($bcc)
					$mail->bcc($bcc);
				try
				{
					$mail->send( 
						new MyMail($from, $company, $subject, $message, $attachments, $slug) 
					);
					$sent = true;
				}
				catch(\Exception $e)
				{
					$sent = false;
				}
			}
			else if($emailMethod == 'sendgrid')
			{
				$message = view(
		    		"mail", 
		    		[
		    			'content' => $message
		    		]
		    	)->render();

				$sent = SendGrid::sendEmail(
					$to,
					$subject,
					$message,
					$cc,
					$bcc,
					$attachments
				);

			}
			else
			{
				throw new \Exception("Email method does not exist.", 500);	
			}

			// Create email log
			if($sent && $log && $log->id)
			{
				$log->sent = 1;
				$log->save();
			}

			return $sent;
		}
		else
		{
			throw new \Exception("Not able to make email log.", 500);
		}
	}

	public static function renderProfileImage($array, $key) {
		return isset($array) && isset($array[$key]) && $array[$key] && file_exists(public_path($array[$key])) ? url($array[$key]) : url('admin/assets/img/noprofile.png') ;
	}

	public static function renderImageUrl($image, $size, $noImage = null)
    {
		$image = FileSystem::getAllSizeImages($image);
		
		if(isset($image) && $image && isset($image[$size]) && $image[$size])
		{
		    return url($image[$size]);
		}
		else
		{
			if(isset($noImage) && $noImage)
			{
				return url($noImage);
			}
			else
			{
				return url('/admin/assets/img/noprofile.png');
			}
		}
    }

	public static function diskSpaceRemaining()
	{
	    if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1')
	    {
	        $dir = "C:";
		    $diskTotalSpace = disk_total_space($dir) / 1073741824;
		    $diskFreeSpace = disk_free_space($dir) / 1073741824;
		}
	    else
	    {
	        $dir = "/";
	        $diskTotalSpace = disk_total_space($dir);
	        $diskFreeSpace = disk_free_space($dir);
	    }
	    
	    $diskFreeSpacePer = round(($diskFreeSpace/$diskTotalSpace)*100, 0);
	    $discStatus = ($diskFreeSpacePer > 0 ) ? 100-$diskFreeSpacePer : 0;
	    return ['disk_total_space' =>round($diskTotalSpace / (1024 * 1024 * 1024), 2), 'disk_free_space' => round($diskFreeSpace / (1024 * 1024 * 1024), 2), 'disc_status' => $discStatus];
	    //return $discStatus = $diskFreeSpacePer;
	}

	public static function pagination($request,$array, $limit = 10)
	{
		$listing = [];
		if(isset($request) && $request)
		{
			$total = count($array);
			$per_page = $limit;
			$current_page = $request->input("page") ?? 1;
			$starting_point = ($current_page * $per_page) - $per_page;
			$array = array_slice($array, $starting_point, $per_page, true);
	    	$listing = new Paginator($array, $total, $per_page, $current_page, [
	            'path'  => $request->url(),
	            'query' => $request->query(),
	            'total' => $total,
	            'currentPage' => $current_page,
	            'perPage' => $per_page,
	        ]);
		}

		return $listing;
	}
	
	/**
	* Render Image if no image it will be show default image
	**/
	public static function renderImage($array, $key = null) 
	{ 
		if(isset($key) && $key)
		{
			return isset($array) && isset($array[$key]) && $array[$key] && file_exists(public_path($array[$key])) ? url($array[$key]) : url('admin/assets/img/no_image.jpg');
		}
		else
		{
           	return isset($array) && isset($array) && $array && file_exists(public_path($array)) ? url($array) : url('admin/assets/img/no_image.jpg');
		}
	}
}