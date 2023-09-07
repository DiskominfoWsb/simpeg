<?php
$claravel = new \MenuLibrary;
$set_active = null;
if(\Input::has('tab')) {
    $set_active = urldecode(\Input::get('tab'));
}
$menu =  $claravel->createMenu($set_active);          
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
          {!!$menu!!}
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>