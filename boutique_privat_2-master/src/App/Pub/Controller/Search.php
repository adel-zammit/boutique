<?php


namespace App\Pub\Controller;


class Search extends AbstractController
{
    public function actionIndex()
    {

    }
    public function actionAuto()
    {
        $value = $this->filter('search', 'str');
        $valueExplodes = explode(' ', $value);
        $products = $this->finder('App:Products')
            ->limit(10)->order('product_date', 'DESC');
        foreach ($valueExplodes as $valueExplode)
        {
            $products->where('title', 'like', '%' . $valueExplode . '%');
        }
        $output = [];
        if($value)
        {
            foreach ($products->fetch() as $product)
            {
                $output[] = [
                    'url' => $this->app()->buildLink('Pub:product', $product),
                    'logo' => \Base\Util\Img::getImg($product, 'icon_date', 'defaultProduct', 'default_img_product', 'm', $this->app()->buildLink('Pub:product', $product)),
                    'title' => $product->title,
                    'stock' => $product->stock,
                    'price' => $product->price
                ];
            }
        }

        return $this->setViewAjax([
            'total' => !empty($value) ? $products->total() : 0,
            'products' => $output,
            'moreResult' => $this->app()->buildLink('Pub:search/view', null, ['q' => $value])
        ]);
    }
}