<?php
$visitor = Base\BaseApp::visitor();
?>
<div class="headerTop">
    <div class="content-header-top">
        <div class="content-header-top-inner">
            <div class="content-logo-site">
                <img src="" alt="site">
            </div>
            <div class="content-search">
                <form method="post" action="<?= $app->buildLink('Pub:search') ?>">
                    <input type="text" name="search" class="input input-search" data-link-search="<?= $app->buildLink('Pub:search/auto') ?>">
                    <button type="submit" class="submit-search">
                        <i class="far fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="content-icon">
                <div class="connect-account">
                    <?php if(!isset($_SESSION['user_id'])) {?>
                    <a href="<?= $app->buildLink('Pub:login') ?>">
                        <?php } else { ?>
                        <a href="<?= $app->buildLink('Pub:account') ?>">
                            <?php } ?>
                            <span class="account-icon"><i class="fas fa-user"></i> </span>
                            Account
                        </a>
                </div>
                <div class="card-account">
                    <a href="<?= $app->buildLink('Pub:carts') ?>">
                        <span class="card-icon"><i class="far fa-shopping-cart"></i></span>
                        <?= \Base\BaseApp::phrase('carts') ?>
                    </a>
                </div>
            </div>
        </div>
        </div>



</div>
<div class="headerBottom">
    <div class="content-header-bottom">
        <div class="content-header-inner">
            <a href="<?= $app->buildLink('Pub:product') ?>">
                <?= \Base\BaseApp::phrase('product') ?>
            </a>
        </div>
    </div>
</div>
<script>
    function renderHtmlSearchProduct(value)
    {
        let html = '<div class="search-content">';
        html += '       <div class="search-cell search-cell-title">';
        html += '           <div class="type-content-flex">';
        html +=  '               <div class="search-cell-pic">';
        html +=  value.logo;
        html += '               </div>';
        html +=  '         <div class="search-cell-txt">';
        html += '            <div class="title">';
        html += '                  <a href="' + value.url + '">' + value.title + '</a>' ;
        html += "            </div>";
        if(value.stock)
        {
            html += '            <div class="stocks in-stock">';
            html += '                <strong>Stock:</strong>';
            html += '                <span>En <em>stock</em></span>';
            html += "            </div>";
        }
        else
        {
            html += '            <div class="stocks hor-stock">';
            html += '                <strong>Stock:</strong>';
            html += '                <span><em>Rupture</em></span>';
            html += "            </div>";
        }
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '       <div class="search-cell search-cell-price">';
        html += priceFormat(value.price);
        html += '   </div>';
        html += '</div>';
        return html;
    }
    $(document).ready(function () {
        $('.input-search').on('input',function(e){
            let url = $(this).data('link-search');
            let valueInput = $(this).val();
            if(valueInput.length !== 0)
            {
                $.ajax({
                    url : url,
                    method : 'post',
                    data : {
                        search : valueInput
                    },
                    dataType : 'json',
                    success : (data) => {
                        let html = '<span class="menu-arrow"></span><div class="search-block-inner">';
                        if (data.products.length)
                        {
                            data.products.forEach((value,key) => {
                                html += renderHtmlSearchProduct(value);
                            });
                        }
                        else
                        {
                            html +=' <div class="search-no-result">';
                            html += 'Aucun résulta !';
                            html += '</div>';
                        }
                        if(data.total > 10)
                        {
                            html +=' <div class="search-footer">';

                            html += '<a href="' + data.moreResult + '">';
                            html +=' <i class="fas fa-plus"></i> Plus de résulta !';
                            html += "</a>";
                            html += '</div>';
                        }

                        html += '</div>';
                        if($('.search-block').length === 0)
                        {
                            let divSearch = $('<div></div>');
                            divSearch.addClass('search-block');
                            divSearch.addClass('block-with-border');
                            divSearch.html(html);
                            $('body').append(divSearch);

                            divSearch.stop(true,true).slideDown();
                        }
                        else
                        {
                            let divSearch = $('.search-block');
                            divSearch.stop(true,true).slideDown();
                            divSearch.html(html);
                        }
                    }
                })
            }
            else
            {
                $('.search-block').stop(true,true).slideUp();
            }
        });
        $('body').click(function(e) {
            let div =  $(this).find('.input-search');
            let div2 =  $(this).find('.search-block');
            if(div2.length)
            {
                if((!$(e.target).is(div) && !$.contains(div[0],e.target)) && (!$(e.target).is(div2) && !$.contains(div2[0],e.target)))
                {
                    div2.stop(true,true).slideUp();
                }
            }

        });
    })

</script>


