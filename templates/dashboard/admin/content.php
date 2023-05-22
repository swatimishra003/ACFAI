<?php
$dashboard_permalink = apply_filters( 'futurewordpress/project/aicontentgenerator/system/getoption', 'permalink-dashboard', 'dashboard' );
$dashboard_permalink = site_url( $dashboard_permalink );
?>
<?php do_action( 'futurewordpress/project/aicontentgenerator/parts/call', 'before_homecontent' ); ?>
<div>
    <?php do_action( 'futurewordpress/project/aicontentgenerator/parts/call', 'homecontent' ); ?>
</div>
<?php do_action( 'futurewordpress/project/aicontentgenerator/parts/call', 'after_homecontent' ); ?>
