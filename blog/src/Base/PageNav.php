<?php 
namespace Base;

class PageNav
{
    protected $options;
    public function getNave($options = [])
    {
        $options = array_merge([
            'data' => [
                'dataName' => '',
                'value' => 0
            ],
            'params' => [],
            'total' => 0,
            'perPage' => 0,
            'link' => '',
            'page' => 0,
            'nameGet' => ''
        ], $options);
        $this->options = $options;
        $perPage = intval($options['perPage']);
        if($perPage <= 0)
        {
            return '';
        }
        $total = intval($options['total']);
        
        if($total <= $perPage)
        {
            return '';
        }
        $totalPage = ceil($total / $perPage);
        $currentPage = intval($options['page']);
        $currentPage = max(1, min($currentPage, $totalPage));
        $range = intval(2);

        $startInner = max(2, $currentPage - $range);
        $endInner = min($currentPage + $range, $totalPage - 1);
                var_dump($totalPage);
        if($startInner <= $endInner)
        {
            $innerPages = range($startInner, $endInner);
        }
        else
        {
            $innerPages = []; 
        }
        $hasSkipStart = ($startInner > 2);
        $hasSkipEnd = ($endInner + 1 < $totalPage);
        $outputLink = $this->getHtml($options['link'], $options['data'], $options['params'], 1);
        if($hasSkipStart)
        {
            $outputLink .= '<div>...</div>';      
        }
        if(!empty($innerPages))
        {
            foreach ($innerPages as $innerPage)
            {
                $outputLink .= $this->getHtml($options['link'], $options['data'], $options['params'], $innerPage);
            }
        }
        if($hasSkipEnd)
        {
            $outputLink .= '<div>...</div>';      
        }
        $outputLink .= $this->getHtml($options['link'], $options['data'], $options['params'], $totalPage);
        return $outputLink;
    }
    public function getHtml($link = '', $data = [], $params = [], $page = 1)
    {
        if($page > 1 )
        {
            $params += [
                $this->options['nameGet'] => $page
            ];
        }
        return '<a href="' . $this->buildLink($link, $data, $params ) . '" >' . $page . '</a>';
    }
    protected function buildLink($link = '', $data = '', $params = [])
    {
        return $link . $this->getParams($data, $params);
    }
    public function  getParams($data = '', $params = [])
    {
        if(!empty($data['dataName']))
        {
            $output = '?' . $data['dataName'] . '=' . $data['value'];
            if(!empty($params))
            {
                $outputParams = [];
                foreach($params as $key => $param)
                {
                    $outputParams[] = $key . '=' . $param;
                } 
                $output .= '&' . implode('&', $outputParams);
            }
            return $output;
        }
        else
        {
            $output = '';
            if(!empty($params))
            {
                $outputParams = [];
                foreach($params as $key => $param)
                {
                    $outputParams[] = $key . '=' . $param;
                } 
                $output .= '?' . implode('&', $outputParams);
            }
            return $output;
        }
    }
}