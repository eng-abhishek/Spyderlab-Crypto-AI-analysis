<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

Class TelegramService{

	protected $token;

	public function __construct(){

		$this->token = env('TelegramToken');
	}

	protected function execute($method, $params = []){

   // $url = 'https://api.telegram.org/bot'.$this->token.'/'.$method;
		$url=sprintf('https://api.telegram.org/bot%s/%s',$this->token,$method);
		$request = Http::post($url,$params);
		return $request->json();
	}

	public function getUpdated(int $offset){

		$response = $this->execute('getUpdates',[
			'offset' => $offset,
		]);
		return $response;
	}

	public function sendMessage(string $chat_id,string $text = null,array $keyboard = null,$inlineKeyboard = null){

	    $markup_array	= array(
			'resize_keyboard' => true,
			'one_time_keyboard' => true,
			'show_alert' => true
			);
        
        if(isset($keyboard)){

        $markup_array['keyboard'] = $keyboard;
        
        }else{

        $markup_array['inline_keyboard'] = $inlineKeyboard;

        }

		$response = $this->execute('sendMessage',[
			'chat_id' => $chat_id,
			'text' => $text,
			'parse_mode' => 'html',
			'reply_markup' => json_encode($markup_array),
		]);

		return $response;
	}

	public function sendPhoto(string $chat_id,string $photo){

     	$response = $this->execute('sendPhoto',[
			'chat_id' => $chat_id,
			'photo' => $photo
		]);
		
		return $response;
	}

	public function setWebhook(string $url,string $certificate){
		$response = $this->execute('setWebhook',[
			'url' => $url,
			'certificate' => $certificate,
		]);
		return $response;
	}

	public function getWebhookUpdate(){

		$response = $this->execute('getWebhookUpdate');
		return $response;
	}

}
?>