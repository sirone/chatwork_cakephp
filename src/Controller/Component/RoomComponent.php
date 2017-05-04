<?php
namespace Chatwork\Controller\Component;

use Chatwork\Controller\Component\ChatworkComponent;

/**
 * ChatworkAPI '/rooms' request Component.
 *
 * @author Shirone Takanashi.
 */
class RoomComponent extends ChatworkComponent
{
	// POST /rooms
	// PUT /rooms/{room_id}
	// icon_preset 用列挙
	const ICON_GROUP		= 'group';
	const ICON_CHECK		= 'check';
	const ICON_DOCUMENT		= 'document';
	const ICON_MEETING		= 'meeting';
	const ICON_EVENT		= 'event';
	const ICON_PROJECT		= 'project';
	const ICON_BUSINESS		= 'business';
	const ICON_STUDY		= 'study';
	const ICON_SECURITY		= 'security';
	const ICON_STAR			= 'star';
	const ICON_IDEA			= 'idea';
	const ICON_HEART		= 'heart';
	const ICON_MAGCUP		= 'magcup';
	const ICON_BEER			= 'beer';
	const ICON_MUSIC		= 'music';
	const ICON_SPORTS		= 'sports';
	const ICON_TRAVEL		= 'travel';
	// DELETE /rooms/{room_id}
	// action_type 用列挙
	const ACTION_LEAVE		= 'leave';
	const ACTION_DELETE		= 'delete';
	// GET /rooms/{room_id}/tasks
	// status 用列挙.
	const STATUS_OPEN		= 'open';
	const STATUS_DONE		= 'done';

	/**
	 * GET リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function get( array $parameters=array() )
	{
		$roomId = isset($parameters['room_id']) ? ('/'.$parameters['room_id']) : '';
		$action = isset($parameters['action']) ? ('/'.$parameters['action']) : '';
		$messageId = isset($parameters['message_id']) ? ('/'.$parameters['message_id']) : '';
		$taskId = isset($parameters['task_id']) ? ('/'.$parameters['task_id']) : '';
		$fileId = isset($parameters['file_id']) ? ('/'.$parameters['file_id']) : '';
		$queryParameters = isset($parameters['query_parameters']) ? $parameters['query_parameters'] : array();
		return parent::getRequest( self::ENDPOINT_ROOMS.$roomId.$action.$messageId.$taskId.$fileId, $queryParameters );
	}
	/**
	 * POST リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function post( array $parameters=array() )
	{
		$roomId = isset($parameters['room_id']) ? ('/'.$parameters['room_id']) : '';
		$action = isset($parameters['action']) ? ('/'.$parameters['action']) : '';
		$queryParameters = isset($parameters['query_parameters']) ? $parameters['query_parameters'] : array();
		return parent::postRequest( self::ENDPOINT_ROOMS.$roomId.$action, $queryParameters );
	}
	/**
	 * PUT リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function put( array $parameters=array() )
	{
		$roomId = isset($parameters['room_id']) ? ('/'.$parameters['room_id']) : '';
		$action = isset($parameters['action']) ? ('/'.$parameters['action']) : '';
		$queryParameters = isset($parameters['query_parameters']) ? $parameters['query_parameters'] : array();
		return parent::putRequest( self::ENDPOINT_ROOMS.$roomId.$action, $queryParameters );
	}
	/**
	 * DELETE リクエスト.
	 *
	 * @param array $parameters 各種パラメータ.
	 */
	public static function del( array $parameters=array() )
	{
		$roomId = isset($parameters['room_id']) ? ('/'.$parameters['room_id']) : '';
		$queryParameters = isset($parameters['query_parameters']) ? $parameters['query_parameters'] : array();
		return parent::deleteRequest( self::ENDPOINT_ROOMS.$roomId, $queryParameters );
	}
	/**
	 * GET /rooms
	 * 自分のチャット一覧の取得
	 */
	public function fetch()
	{
		$response = self::get();
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}
	 * チャットの名前、アイコン、種類(my/direct/group)を取得.
	 *
	 * @param integer $roomId ルームID.
	 */
	public function fetches( $roomId )
	{
		$response = self::get(['room_id'=>(int)$roomId]);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/members
	 * チャットのメンバー一覧を取得.
	 *
	 * @param integer $roomId ルームID.
	 */
	public function fetchMembers( $roomId )
	{
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'members']);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/messages
	 * チャットのメッセージ一覧を取得.
	 * @TODO ページネーション未対応. Chatwork 側が機能未実装らしい.
	 *
	 * @param integer $roomId ルームID.
	 */
	public function fetchMessages( $roomId )
	{
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'messages']);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/messages/{message_id}
	 * メッセージ情報を取得.
	 *
	 * @param integer $roomId ルームID.
	 * @param integer $messageId メッセージID.
	 */
	public function fetchMessage( $roomId, $messageId )
	{
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'messages', 'message_id'=>$messageId]);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/tasks
	 * チャットのタスク一覧を取得.
	 * @TODO ページネーション未対応. Chatwork 側が機能未実装らしい.
	 *
	 * @param integer $roomId ルームID.
	 * @param integer $accountId タスクの担当者のアカウントID.
	 * @param integer $assignedByAccountId タスクの依頼者のアカウントID.
	 * @param string $status タスクのステータス. (open, done)
	 */
	public function fetchTasks( $roomId, $accountId=null, $assignedByAccountId=null, $status=null )
	{
		$queryParameters = [
			'account_id'				=> !empty($accountId) ? $accountId : null,	// 任意.
			'assigned_by_account_id'	=> !empty($assignedByAccountId) ? $assignedByAccountId : null,	// 任意.
			'status'					=> !empty($status) ? $status : null,	// 任意.
		];
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'tasks', 'query_parameters'=>$queryParameters]);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/tasks/{task_id}
	 * タスク情報を取得.
	 *
	 * @param integer $roomId ルームID.
	 * @param integer $taskId タスクID.
	 */
	public function fetchTask( $roomId, $taskId )
	{
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'tasks', 'task_id'=>$taskId]);
		return $response['body'];
	}
	/**
	 * GET /rooms/{room_id}/files
	 * チャットのファイル一覧を取得.
	 * @TODO ページネーション未対応.
	 *
	 * @param integer $roomId ルームID.
	 * @param integer $accountId アップロードしたユーザーのアカウントID.
	 */
	public function fetchFiles( $roomId, $accountId=null )
	{
		$queryParameters = [
			'account_id' => !empty($accountId) ? $accountId : null,	// 任意.
		];
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'files', 'query_parameters'=>$queryParameters]);
		return $response['body'];
	}
	/**
	* GET /rooms/{room_id}/files/{file_id}
	* ファイル情報を取得.
	 *
	 * @param integer $roomId ルームID.
	 * @param integer $fileId アップロードしたファイルID.
	 * @param boolean $isCreateDownloadUrl ダウンロードする為のURLを生成するか 30 秒間だけダウンロード可能なURLを生成します.
	 */
	public function fetchFile( $roomId, $fileId, $isCreateDownloadUrl=false )
	{
		$queryParameters = [
			'create_download_url' => !empty($isCreateDownloadUrl) ? $isCreateDownloadUrl : null,	// 任意.
		];
		$response = self::get(['room_id'=>(int)$roomId,'action'=>'files', 'file_id'=>$fileId, 'query_parameters'=>$queryParameters]);
		debug( $response['info']['url'] );
		return $response['body'];
	}

	/**
	* POST /rooms
	* グループチャットを新規作成.
	*
	* @param string $name 作成したいグループチャットのチャット名.
	* @param array $membersAdminIds 管理者権限のユーザー.<br />
	*                          作成したチャットに参加メンバーのうち、管理者権限にしたいユーザーのアカウントIDの配列.<br />
	*                          最低1人は指定する必要がある.
	* @param array $membersMemberIds メンバー権限のユーザー.<br />
	*                           作成したチャットに参加メンバーのうち、メンバー権限にしたいユーザーのアカウントIDの配列.
	* @param array $membersReadOnlyIds 閲覧のみ権限のユーザー.<br />
	*                             作成したチャットに参加メンバーのうち、閲覧のみ権限にしたいユーザーのアカウントIDの配列.
	* @param string $description グループチャットの概要説明テキスト.
	* @param string $iconPreset グループチャットのアイコン種類. (group, check, document, meeting, event, project, business, study, security, star, idea, heart, magcup, beer, music, sports, travel)
	 */
	public function create( $name, array $membersAdminIds, array $membersMemberIds=null, array $membersReadOnlyIds=null, $description='', $iconPreset='' )
	{
		$queryParameters = [
			'name'					=> $name,	// 必須.
			'members_admin_ids'		=> implode(',',$membersAdminIds),	// 必須.
			'members_member_ids'	=> (isset($membersMemberIds)&&(!empty($membersMemberIds))) ? implode(',',$membersMemberIds) : null,	// 任意.
			'members_readonly_ids'	=> (isset($membersReadOnlyIds)&&(!empty($membersReadOnlyIds))) ? implode(',',$membersReadOnlyIds) : null,	// 任意.
			'description'			=> (isset($description)&&(!empty($description))) ? $description : null,	// 任意.
			'icon_preset'			=> (isset($iconPreset)&&(!empty($iconPreset))) ? $iconPreset : null,	// 任意.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response = self::post( ['query_parameters'=>$queryParameters] );
		return $response['body'];
	}

	/**
	 * POST /rooms/{room_id}/messages
	 * チャットに新しいメッセージを追加.
	 *
	 * @param integer $roomId ルームID.
	 * @param string $body 本文.
	 */
	public function postMessage( $roomId, $body )
	{
		$queryParameters = [
			'body' => $body,	// 必須.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response = self::post( array('room_id'=>$roomId, 'action'=>'messages', 'query_parameters'=>$queryParameters) );
		return $response['body'];
	}

	/**
	 * POST /rooms/{room_id}/tasks
	 * チャットに新しいタスクを追加.
	 *
	 * @param integer $roomId ルームID.
	 * @param string $body 本文.
	 * @param array $toIds 担当者のアカウント ID.
	 * @param integer $limit タスクの期限. Unix Time で入力してください.
	 */
	public function postTask( $roomId, $body, array $toIds=null, $limit=null )
	{
		$queryParameters = [
			'body'		=> $body,	// 必須.
			'to_ids'	=> (isset($toIds)&&(!empty($toIds))) ? implode(',',$toIds) : null,	// 任意.
			'limit'		=> (isset($limit)&&(!empty($limit))) ? $limit : null,	// 任意.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response = self::post( array('room_id'=>$roomId, 'action'=>'tasks', 'query_parameters'=>$queryParameters) );
		return $response['body'];
	}

	/**
	 * PUT /rooms/{room_id}
	 * チャットの名前、アイコンをアップデート.
	 *
	 * @param integer $roomId ルームID.
	 * @param string $name グループチャットのチャット名.
	 * @param string $description グループチャットの概要説明テキスト.
	 * @param string $iconPreset グループチャットのアイコン種類. (group, check, document, meeting, event, project, business, study, security, star, idea, heart, magcup, beer, music, sports, travel)
	 */
	public function edit( $roomId, $name, $description=null, $iconPreset=null )
	{
		$queryParameters = [
			'name'			=> $name,	// 必須.
			'description'	=> (isset($description)&&(!empty($description))) ? $description : null,	// 任意.
			'icon_preset'	=> (isset($iconPreset)&&(!empty($iconPreset))) ? $iconPreset : null,	// 任意.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response = self::put( array('room_id'=>$roomId, 'query_parameters'=>$queryParameters) );
		return $response['body'];
	}

	/**
	 * PUT /rooms/{room_id}/members
	 * チャットのメンバーを一括変更.
	 *
	 * @param integer $roomId ルームID.
	 * @param array $membersAdminIds 管理者権限のユーザー.<br />
	 *                          作成したチャットに参加メンバーのうち、管理者権限にしたいユーザーのアカウントIDの配列.<br />
	 *                          最低1人は指定する必要がある.
	 * @param array $membersMemberIds メンバー権限のユーザー.<br />
	 *                           作成したチャットに参加メンバーのうち、メンバー権限にしたいユーザーのアカウントIDの配列.
	 * @param array $membersReadOnlyIds 閲覧のみ権限のユーザー.<br />
	 *                             作成したチャットに参加メンバーのうち、閲覧のみ権限にしたいユーザーのアカウントIDの配列.
	 */
	public function editMembers( $roomId, array $membersAdminIds, array $membersMemberIds=null, array $membersReadOnlyIds=null )
	{
		$queryParameters = [
			'members_admin_ids'		=> implode(',',$membersAdminIds),	// 必須.
			'members_member_ids'	=> (isset($membersMemberIds)&&(!empty($membersMemberIds))) ? implode(',',$membersMemberIds) : null,	// 任意.
			'members_readonly_ids'	=> (isset($membersReadOnlyIds)&&(!empty($membersReadOnlyIds))) ? implode(',',$membersReadOnlyIds) : null,	// 任意.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response = self::put( array('room_id'=>$roomId, 'action'=>'members', 'query_parameters'=>$queryParameters) );
		return $response['body'];
	}

	/**
	 * DELETE /rooms/{room_id}
	 * グループチャットを退席する.
	 *
	 * 退席すると、このグループチャットにある自分が担当のタスク、および自分が送信したファイルは削除されます.<br />
	 * ※一度削除すると元に戻せません！
	 *
	 * @param integer $roomId ルームID.
	 */
	public function leave( $roomId )
	{
		return self::_leave_or_delete( $roomId, self::ACTION_LEAVE );
	}

	/**
	 * DELETE /rooms/{room_id}
	 * グループチャットを削除する.
	 *
	 * 削除すると、このグループチャットに参加しているメンバー全員のメッセージ、タスク、ファイルはすべて削除されます.<br />
	 * ※一度削除すると元に戻せません！
	 *
	 * @param integer $roomId ルームID.
	 */
	public function delete( $roomId )
	{
		return self::_leave_or_delete( $roomId, self::ACTION_DELETE );
	}

	/**
	 * DELETE /rooms/{room_id}
	 * グループチャットを削除/退席する.
	 *
	 * 退席すると、このグループチャットにある自分が担当のタスク、および自分が送信したファイルは削除されます.<br />
	 * 削除すると、このグループチャットに参加しているメンバー全員のメッセージ、タスク、ファイルはすべて削除されます.<br />
	 * ※一度削除すると元に戻せません！
	 *
	 * @param integer $roomId ルームID.
	 * @param string $action 退席するか削除するか. (leave, delete)
	 */
	protected static function _leave_or_delete( $roomId, $action )
	{
		$queryParameters = [
			'action_type' => $action,	// 必須.
		];
		$queryParameters = self::_nullFilter( $queryParameters );
		$response= self::del( array('room_id'=>$roomId, 'query_parameters'=>$queryParameters) );
		return $response['body'];
	}
}
