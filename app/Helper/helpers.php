<?php


if( !function_exists('successResponseData')) {

    /**
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function successResponseData ($code = 200, $data = [])
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
        ]);
    }
}

if( !function_exists('successResponse')) {
    /**
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function successResponse ($code = 200)
    {
        return response()->json([
            'code' => $code,
        ]);
    }
}

if( !function_exists('errorResponseData')) {
    /**
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function errorResponseData ($code = 400, $message = '未知错误！')
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
        ], 400);
    }
}

if( !function_exists('getAdminMenuList')) {
    /**
     * 遍历-格式化菜单数据
     * @param $menus
     * @param int $pid
     * @param array $result
     * @return array
     */
    function getAdminMenuList ($menus, $pid = 0, &$result = [])
    {
        $num = 0;
        foreach ($menus as $m_key => $m_val) {
            if($m_val['parent_id'] == $pid) {
                $result[$num]['id']        = $m_val['id'];
                $result[$num]['path']      = $m_val['m_url'];
                $result[$num]['name']      = $m_val['name'];
                $result[$num]['icon']      = $m_val['m_icon'];
                $result[$num]['title']     = $m_val['m_lable'];
                $result[$num]['parent_id'] = $m_val['parent_id'];
                $result[$num]['children']  = getAdminMenuList($menus, $m_val['id']);
                $num++;
            }
        }

        return $result;
    }
}

if( !function_exists('getFormatMenuTree')) {
    /**
     * @param array $menus
     * @param int $pid
     * @param array $result
     * @param array $menu_selected
     * @return array
     */
    function getFormatMenuTree ($menus = [], $pid = 0, $menu_selected = [], &$result = [])
    {
        $num = 0;
        if(!empty($menus)) {
            foreach ($menus as $m_val) {
                if($m_val['parent_id'] == $pid) {
                    $result[$num]['title']  = $m_val['m_lable'];
                    $result[$num]['expand'] = true;
                    $result[$num]['p_id']   = $pid;
                    $result[$num]['m_id']   = $m_val['id'];
                    if($m_val['id'] == 1) {
                        $result[$num]['disabled'] = true;
                    }
                    if(in_array($m_val['id'], $menu_selected) && $m_val['parent_id'] !== 0) {
                        $result[$num]['checked'] = true;
                    }
                    $result[$num]['children'] = getFormatMenuTree($menus, $m_val['id'], $menu_selected);
                    $num++;
                }
            }

            return $result;
        }
    }
}