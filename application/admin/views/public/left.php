<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
            </li>
            <?php foreach($menu_list as $v):?>
                <li <?php if(isset($v['active'])):?>class="active"<?php endif;?> >
                    <a <?php if(isset($v['active'])&&(!isset($v['child']))):?>class="active"<?php endif;?> href="<?php echo $v['link'];?>"><i class="fa fa-fw <?php echo $v['style'];?>"></i> <?php echo $v['name']?> <?php if(isset($v['child'])):?><span class="fa arrow"></span><?php endif;?></a>

                    <?php if(isset($v['child'])):?>
                    <ul class="nav nav-second-level collapse">
                        <?php foreach($v['child'] as $vv):?>
                            <li>
                                <a <?php if(isset($vv['active'])):?>class="active"<?php endif;?> href="<?php echo $vv['link'];?>"><?php echo $vv['name'];?> <?php if(isset($vv['child'])):?><span class="fa arrow"></span><?php endif;?></a>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    <?php endif;?>

                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><?php echo $menu_cur;?></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>