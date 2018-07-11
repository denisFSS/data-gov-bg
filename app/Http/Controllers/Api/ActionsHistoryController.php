<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use \App\ActionsHistory;
use \App\DataSet;
use \App\User;
use \Validator;

class ActionsHistoryController extends ApiController
{
    /**
     * Lists actions based on request input
     *
     * @param Request $request
     * @return json response
     */
    public function listActionHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'criteria'             => 'array',
            'criteria.period_from' => 'date',
            'criteria.period_to'   => 'date',
            'criteria.username'    => 'string',
            'criteria.user_id'     => 'integer',
            'criteria.module'      => 'string',
            'criteria.action'      => 'integer',
            'criteria.category_id' => 'integer',
            'criteria.tag_id'      => 'integer',
            'criteria.org_id'      => 'integer',
            'criteria.group_id'    => 'integer',
            'criteria.dataset_uri' => 'string',
            'criteria.ip_adress'   => 'string',
            'records_per_page'     => 'integer',
            'page_number'          => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('List action history failure');
        }

        $result = [];
        $criteria = is_array($request->json('criteria')) ? $request->json('criteria') : null;
        $filters = [
            'period_from',
            'period_to',
            'username',
            'user_id',
            'module',
            'action',
            'category_id',
            'tag_id',
            'org_id',
            'group_id',
            'dataset_uri',
            'ip_address',
        ];

        if (is_array($criteria)) {
            foreach ($criteria as $key => $value) {
                if (!in_array($key, $filters)) {
                    unset($criteria[$key]);
                }
            }
        }

        $actionList = '';
        $actionList = ActionsHistory::all();
        if (is_null($criteria)) {
            $actionList = $actionList;
        }

        if (isset($criteria['period_from'])) {
            $actionList = $actionList->where('occurence', '>=', $criteria['period_from']);
        }

        if (isset($criteria['period_to'])) {
            $actionList = $actionList->where('occurence', '<=', $criteria['period_to']);
        }

        if (isset($criteria['username'])) {
            $user = User::whereUsername($criteria['username'])->get();
            if ($user->isEmpty()) {
                return $this->errorResponse('List action history failure');
            }
            $actionList = $actionList->whereIn('user_id', $user->pluck('id'));
        }

        if (isset($criteria['user_id'])) {
            $actionList = $actionList->where('user_id', $criteria['user_id']);
        }

        if (isset($criteria['module'])) {
            $actionList = $actionList->where('module_name', $criteria['module']);
        }

        if (isset($criteria['ip_address'])) {
            $actionList = $actionList->where('ip_address', $criteria['ip_address']);
        }

        if (isset($criteria['action'])) {
            $actionList = $actionList->where('action', $criteria['action']);
        }

        if (isset($criteria['category_id'])) {
            $actionList = $actionList->where('module_name', ActionsHistory::MODULE_NAMES[0]);
            $actionList = $actionList->where('action_object', $criteria['category_id']);
        }

        if (isset($criteria['tag_id'])) {
            $actionList = $actionList->where('module_name', ActionsHistory::MODULE_NAMES[1]);
            $actionList = $actionList->where('action_object', $criteria['tag_id']);
        }

        if (isset($criteria['org_id'])) {
            $actionList = $actionList->where('module_name', ActionsHistory::MODULE_NAMES[2]);
            $actionList = $actionList->where('action_object', $criteria['org_id']);
        }

        if (isset($criteria['group_id'])) {
            $actionList = $actionList->where('module_name', ActionsHistory::MODULE_NAMES[3]);
            $actionList = $actionList->where('action_object', $criteria['group_id']);
        }

        if (isset($criteria['dataset_uri'])) {
            $dataSet = DataSet::whereUri($criteria['dataset_uri'])->get();
            if ($dataSet->isEmpty()) {
                return $this->errorResponse('List action history failure');
            }
            $actionList = $actionList->where('module_name', [ActionsHistory::MODULE_NAMES[2], ActionsHistory::MODULE_NAMES[0]]);
            $actionList = $actionList->where('action_object', $dataSet->org_id);
        }

        if (isset($request['records_per_page']) || isset($request['page_number'])) {
            $actionList = $actionList->forPage($request->input('page_number'), $request->input('records_per_page'));
        }
        
        $total_records = $actionList->count();
        if (!empty($actionList)) {
            $users = User::all();
            foreach ($actionList as $action) {
                $result[] = [
                    'user' => $users->firstWhere('id', $action->user_id)->username,
                    'ocurrence' => $action->occurence,
                    'module' => $action->module_name,
                    'action' => $action->action,
                    'action_object' => $action->action_object,
                    'action_msg' => $action->action_msg,
                ];
            }
        }
        return $this->successResponse([$result, 'total_records' => $total_records], true);
    }
}
