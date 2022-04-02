<?php

namespace Qiyewechat;

use Qiyewechat\client\QYAPIClient;
use Qiyewechat\request\DepartmentListRequest;
use Qiyewechat\response\DepartmentListResponse;

class Department extends BaseObject
{

    /**
     * 获取部门下所有
     *
     * @return DepartmentListResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllDepartment()
    {
        $request = DepartmentListRequest::getInstance([
            'department_id' => 0,
        ]);
        $response = QYAPIClient::getInstance()->send($request);
        if ($response) {
            $response = new DepartmentListResponse($response);
            if ($response->isSuccess()) {
                return $response;
            }
        }
        throw new \Exception('Get department list error.');
    }
}
