<script src="<?php echo base_url('assets/js/jquery.app.js');?>"></script>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-default btn-rounded waves-effect waves-light back_btn">
                               <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back
                            </button>
                        </div>
                        <h4 class="page-title">Play Video</h4>
                        <ol class="breadcrumb"> </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b></b></h4>
                            <div class="player_wrapper">
                                <div class="player_container" style="text-align: center;">
                                    <video width="900", controls>
                                        <source src="<?php echo $result->link;?>" type='video/mp4'>
                                        <source src="<?php echo $result->link;?>" type='video/avi'>
                                        Your Browser does not support HTML5 video.    
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->    
    </div> <!-- content-page -->
</div>
        <!-- END wrapper -->

<script type="text/javascript">
    var $dom = {
        backBtn:$('.back_btn')
    }

    $dom.backBtn.on('click', function() {
        window.location.href = "<?php echo base_url().'Cms/data/'?>";
    })
</script>