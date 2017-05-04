<?php
namespace Chatwork\Controller\Component;

use Cake\Controller\Component;

/**
 * ChatworkAPI '/contacts' request Component.
 *
 * @author Shirone Takanashi.
 */
class ContactComponent extends ChatworkComponent
{
	/**
	 * GET リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function get( array $parameters=array() )
	{
		return parent::getRequest( self::ENDPOINT_CONTACTS, $parameters );
	}

	/**
	 * GET /contacts
	 * 自分のコンタクト一覧を取得.
	 */
	public static function fetch()
	{
		$response = self::get([]);
		return $response['body'];
	}
}
