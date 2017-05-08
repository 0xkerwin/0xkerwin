<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?php 
            use backend\modules\rbac\components\MenuHelper; 

            $callback = function($menu){
                $data = json_decode($menu['data'], true);
                $items = $menu['children'];
                $return = ['label' => $menu['name'],'url' => [$menu['route']]];
                //处理我们的配置
                if ($data) {
                    isset($data['visible']) && $return['visible'] = $data['visible'];//visible
                    isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];//icon
                    //other attribute e.g. class...
                    $return['options'] = $data;
                }
                //没配置图标的显示默认图标
                (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
                $items && $return['items'] = $items;
                
                return $return;
            };
            
         ?>

        <?php /*echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'User', 'icon' => 'fa fa-user', 'url' => ['/user-backend']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );*/

        echo dmstr\widgets\Menu::widget( [
        'options' => ['class' => 'sidebar-menu'],
            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id,null, $callback),
        ] ); 
         ?>
        <!-- <ul class="sidebar-menu">            
            <li class="treeview">               
                <a href="#">                    
                    <i class="fa fa-gears"></i> <span>权限控制</span>                    
                    <i class="fa fa-angle-left pull-right"></i>               
                </a>               
                <ul class="treeview-menu">                   
                    <li class="treeview">                        
                        <a href="/admin">管理员</a>                        
                        <ul class="treeview-menu">                            
                            <li><a href="/user-backend"><i class="fa fa-user"></i> 后台用户</a></li>                            
                            <li class="treeview">                                
                                <a href="/admin/role">                                    
                                    <i class="fa fa-circle-o"></i> 权限 <i class="fa fa-angle-left pull-right"></i>                                
                                </a>                                
                                <ul class="treeview-menu">                                    
                                    <li><a href="/admin/route"><i class="fa fa-circle-o"></i> 路由</a></li>                                    
                                    <li><a href="/admin/permission"><i class="fa fa-circle-o"></i> 权限</a></li>                                    
                                    <li><a href="/admin/role"><i class="fa fa-circle-o"></i> 角色</a></li>                                    
                                    <li><a href="/admin/assignment"><i class="fa fa-circle-o"></i> 分配</a></li>                                    
                                    <li><a href="/admin/menu"><i class="fa fa-circle-o"></i> 菜单</a></li>                                
                                </ul>                           
                            </li>                        
                        </ul>                    
                    </li>                
                </ul>            
            </li>        
        </ul> -->

    </section>

</aside>
