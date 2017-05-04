<?php
namespace Chatwork\Controller\Component;

use Cake\Controller\Component;

abstract class ChatworkComponent extends Component
{
	/**
	 * @var エンドポイントのベース URI.
	 */
	const ENDPOINT_BASE_URI = 'https://api.chatwork.com/v2';
	/**
	 * 自分自身の情報にアクセスする.
	 */
	const ENDPOINT_ME = '/me';
	/**
	 * 自分が持つデータへアクセスする.
	 */
	const ENDPOINT_MY = '/my';
	/**
	 * 自分がコンタクトしているユーザーの一覧へアクセスする.
	 */
	const ENDPOINT_CONTACTS = '/contacts';
	/**
	 * チャットの情報へアクセスする.
	 */
	const ENDPOINT_ROOMS = '/rooms';
	/**
	 * ChatworkAPI のトークン.
	 */
	const TOKEN = \Chatwork\API_TOKEN;
	/**
	 * GET リクエスト.
	 *
	 * @param string $endpoint ENDPOINT_* クラス定数.
	 * @param array $parameters 各種パラメータ.
	 * @return array レスポンス内容をまとめた連想配列.
	 * ['method']=>'GET','uri'=>'http://example.com','header'=>array(...),'body'=>array(...)]
	 */
	public static function getRequest( $endpoint, array $parameters )
	{
		$queryParameters = http_build_query( $parameters );
		$requestUri = self::ENDPOINT_BASE_URI.$endpoint.(($queryParameters!=='') ? ('?'.$queryParameters) : '');
		$curlInstance = curl_init( $requestUri );
		$curlOptions = [
			CURLOPT_RETURNTRANSFER	=> true,	// true を設定すると、curl_exec()  の返り値を 文字列で返す.
			CURLOPT_FAILONERROR		=> false,	// エラー処理.
			CURLOPT_SSL_VERIFYPEER	=> false,	// false を設定すると、CURL はサーバ証明書の検証を行いません.
			CURLOPT_HEADER			=> true,	// true を設定すると、ヘッダの内容も出力します.
			CURLOPT_POST			=> false,	// true を設定すると、HTTP POST を行います.
			CURLOPT_HTTPHEADER		=> array(self::TOKEN),	// API トークン.
		];
		curl_setopt_array( $curlInstance, $curlOptions );
		$response = curl_exec( $curlInstance );
		$information = curl_getinfo( $curlInstance );
		$response = explode("\r\n\r\n",$response); // ヘッダと内容を分割.
		return self::_afterRequest(self::_responseFormated('GET', $requestUri, explode("\r\n",$response[0]), json_decode($response[1]),$information), null);
	}

	/**
	 * POST リクエスト.
	 *
	 * @param string $endpoint ENDPOINT_* クラス定数.
	 * @param array $parameters 各種パラメータ.
	 * @return array レスポンス内容をまとめた連想配列.
	 * ['method']=>'GET','uri'=>'http://example.com','header'=>array(...),'body'=>array(...)]
	 */
	public static function postRequest( $endpoint, array $parameters )
	{
		$requestUri = self::ENDPOINT_BASE_URI.$endpoint;
		$curlInstance = curl_init( $requestUri );
		$data = http_build_query( $parameters );
		$curlOptions = [
			CURLOPT_RETURNTRANSFER	=> true,		// true を設定すると、curl_exec()  の返り値を 文字列で返す.
			CURLOPT_FAILONERROR		=> false,		// エラー処理.
			CURLOPT_SSL_VERIFYPEER	=> false,		// false を設定すると、CURL はサーバ証明書の検証を行いません.
			CURLOPT_HEADER			=> true,		// true を設定すると、ヘッダの内容も出力します.
			CURLOPT_POST			=> true,		// true を設定すると、HTTP POST を行います.
			CURLOPT_POSTFIELDS		=> $data,		// 送信するすべてのデータ.
			CURLOPT_HTTPHEADER		=> array(self::TOKEN),	// API トークン.
		];
		curl_setopt_array( $curlInstance, $curlOptions );
		$response = curl_exec( $curlInstance );
		$information = curl_getinfo( $curlInstance );
		$response = explode("\r\n\r\n",$response); // ヘッダと内容を分割.
		return self::_afterRequest(self::_responseFormated('POST', $requestUri, explode("\r\n",$response[0]), json_decode($response[1]),$information), $data);
	}

	/**
	 * PUT リクエスト.
	 *
	 * @param string $endpoint ENDPOINT_* クラス定数.
	 * @param array $parameters 各種パラメータ.
	 * @return array レスポンス内容をまとめた連想配列.
	 * ['method']=>'GET','uri'=>'http://example.com','header'=>array(...),'body'=>array(...)]
	 */
	public static function putRequest( $endpoint, array $parameters )
	{
		$requestUri = self::ENDPOINT_BASE_URI.$endpoint;
		$curlInstance = curl_init( $requestUri );
		$data = http_build_query( $parameters );
		$curlOptions = [
			CURLOPT_RETURNTRANSFER	=> true,		// true を設定すると、curl_exec()  の返り値を 文字列で返す.
			CURLOPT_FAILONERROR		=> false,		// エラー処理.
			CURLOPT_SSL_VERIFYPEER	=> false,		// false を設定すると、CURL はサーバ証明書の検証を行いません.
			CURLOPT_HEADER			=> true,		// true を設定すると、ヘッダの内容も出力します.
			CURLOPT_POST			=> false,		// true を設定すると、HTTP POST を行います.
			CURLOPT_POSTFIELDS		=> $data,		// 送信するすべてのデータ.
			CURLOPT_CUSTOMREQUEST	=> 'PUT',		// GET,POST 以外の Restful なリクエストのメソッド指定に用います.
			CURLOPT_HTTPHEADER		=> array(self::TOKEN),	// API トークン.
		];
		curl_setopt_array( $curlInstance, $curlOptions );
		$response = curl_exec( $curlInstance );
		$information = curl_getinfo( $curlInstance );
		$response = explode("\r\n\r\n",$response); // ヘッダと内容を分割.
		return self::_afterRequest(self::_responseFormated('PUT', $requestUri, explode("\r\n",$response[0]), json_decode($response[1]),$information), $data);
	}

	/**
	 * DELETE リクエスト.
	 *
	 * @param string $endpoint ENDPOINT_* クラス定数.
	 * @param array $parameters 各種パラメータ.
	 * @return array レスポンス内容をまとめた連想配列.
	 * ['method']=>'GET','uri'=>'http://example.com','header'=>array(...),'body'=>array(...)]
	 */
	public static function deleteRequest( $endpoint, array $parameters )
	{
		$requestUri = self::ENDPOINT_BASE_URI.$endpoint;
		$curlInstance = curl_init( $requestUri );
		$data = http_build_query( $parameters );
		$curlOptions = [
			CURLOPT_RETURNTRANSFER	=> true,		// true を設定すると、curl_exec()  の返り値を 文字列で返す.
			CURLOPT_FAILONERROR		=> false,		// エラー処理.
			CURLOPT_SSL_VERIFYPEER	=> false,		// false を設定すると、CURL はサーバ証明書の検証を行いません.
			CURLOPT_HEADER			=> true,		// true を設定すると、ヘッダの内容も出力します.
			CURLOPT_POST			=> false,		// true を設定すると、HTTP POST を行います.
			CURLOPT_POSTFIELDS		=> $data,		// 送信するすべてのデータ.
			CURLOPT_CUSTOMREQUEST	=> 'DELETE',	// GET,POST 以外の Restful なリクエストのメソッド指定に用います.
			CURLOPT_HTTPHEADER		=> array(self::TOKEN),	// API トークン.
		];
		curl_setopt_array( $curlInstance, $curlOptions );
		$response = curl_exec( $curlInstance );
		$information = curl_getinfo( $curlInstance );
		$response = explode("\r\n\r\n",$response); // ヘッダと内容を分割.
		return self::_afterRequest(self::_responseFormated('DELETE', $requestUri, explode("\r\n",$response[0]), json_decode($response[1]),$information), $data);
	}

	/**
	 * レスポンス内容を整形して返す.
	 *
	 * @param string $method リクエストメソッド. (GET, POST, PUT, DELETE, etc...)
	 * @param string $uri リクエスト先の URI.
	 * @param array headers リクエストヘッダ.
	 * @param array bodies リクエスト内容の連想配列.
	 * @param array curl_information curl_getinfo の返り値.
	 * @return array レスポンス内容をまとめた連想配列.
	 * ['method']=>'GET','uri'=>'http://example.com','header'=>array(...),'body'=>array(...)]
	 */
	protected static function _responseFormated( $method, $uri, $headers, $bodies, $curlInformation )
	{
		return [
			'method' => $method,
			'uri'    => $uri,
			'header' => $headers,
			'body'   => $bodies,
			'info'   => $curlInformation,
		];
	}

	/**
	 * リクエスト完了後に呼び出されるコールバック.
	 *
	 * @param array $response self::_responseFormated() の返り値.
	 * @param array $request リクエスト時のデータ. (CURL の CURLOPT_POSTFIELDS パラメータに渡すデータ.)
	 * @return mixed
	 */
	protected static function _afterRequest( $response, $request )
	{
		var_dump($request);
		var_dump($response);
		return $response;
	}

	/**
	 * 連想配列の値が null の要素を省いた連想配列を返す.
	 *
	 * @param array $parameters 連想配列.
	 */
	protected static function _nullFilter( array $parameters )
	{
		return array_filter( $parameters, function($v){return $v!==null;} );
	}
}
