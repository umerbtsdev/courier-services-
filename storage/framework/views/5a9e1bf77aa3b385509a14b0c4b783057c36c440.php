<?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "Chart of Account")): ?>
    <li class="<?php echo (Request::is('Finance/Chart-of-Account')) ? 'active custom':''; ?>" ><a href="<?php echo e(url('/Finance/Chart-of-Account')); ?>">
        <i class="fa fa-angle-right"></i> <span>Chart of Account</span></a>
    </li>
<?php endif; ?>