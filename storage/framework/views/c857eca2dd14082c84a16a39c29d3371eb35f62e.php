<?php if(App\Helper\Common::userwisepermission(Auth::user()->id, "General Voucher")): ?>
    <li class="<?php echo (Request::is('Finance/General-Voucher')) ? 'active custom':''; ?>" >
        <a href="<?php echo e(url('/Finance/General-Voucher')); ?>" class="p-t-0 p-l-10">
            <i class="fa fa-angle-right p-t-4 p-l-6 m-r-6"></i> <span>General Voucher</span>
        </a>
    </li>
<?php endif; ?>