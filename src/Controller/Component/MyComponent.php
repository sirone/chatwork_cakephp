<?php
namespace Chatwork\Controller\Component;

use Chatwork\Controller\Component\ChatworkComponent;
use \BadMethodCallException;

/**
 * ChatworkAPI '/my' request Component.
 *
 * @author Shirone Takanashi.
 */
class MyComponent extends ChatworkComponent
{
	/**
	 * GET リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function get( array $parameters=array() )
	{
		$action = (isset($parameters['action'])&&is_string($parameters['action'])) ? (self::ENDPOINT_MY.'/'.$parameters['action']) : '';
		if( $action === '' ) {
			throw new BadMethodCallException('You must specify the action. ex: $api->get([\'action\'=>\'status\']);');
		}
		unset( $parameters['action'] );
		return parent::getRequest( $action, $parameters );
	}

	/**
	 * GET /my/status
	 * 自分の未読数、未読To数、未完了タスク数を返す.
	 */
	public function fetchStatus()
	{
		$response = self::get( ['action'=>'status'] );
		return $response['body'];
	}

	/**
	 * GET /my/tasks
	 * 自分のタスク一覧を取得する.
	 * @TODO ページネーション未対応. Chatwork 側が機能未実装らしい.
	 *
	 * 引数0：assigned_by_account_id タスクの依頼者のアカウントID.
	 * 引数1：status タスクのステータス. (open, done)
	 */
	public function fetchTasks()
	{
		$response = self::get( ['action'=>'tasks'] );
		return $response['body'];
	}
}
