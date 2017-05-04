<?php
namespace Chatwork\Controller\Component;

use Chatwork\Controller\Component\ChatworkComponent;

/**
 * ChatworkAPI '/me' request Component.
 *
 * @author Shirone Takanashi.
 */
class MeComponent extends ChatworkComponent
{
	/**
	 * GET リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function get( array $parameters=array() )
	{
		return parent::getRequest( self::ENDPOINT_ME, $parameters );
	}

	/**
	 * 自分自身の情報にアクセスする.
	 */
	public function fetch()
	{
		$response = self::get([]);
		return $response['body'];
	}
}
