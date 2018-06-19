<link href="<?php echo base_url('assets/plugins/bootstrap-select/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/bootstrap-select/js/bootstrap-select.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js');?>" type="text/javascript"></script>
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
                        <h4 class="page-title">Add&Edit Data</h4>
                        <ol class="breadcrumb"> </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="row">
                                <form action="<?php echo base_url().'Cms_api/add_data';?>" enctype="multipart/form-data" data-parsley-validate="" novalidate="" class="form-horizontal" method="post" id="linkUpload">
                                    <input type="hidden" name="data_Id" value="<?php echo $data_Id;?>">
                                    <div class="col-lg-3">
                                        <div class="trigger_pic">
                                            <img class="img-responsive img-thumbnail" id="thumbnailPic" src="<?php 
                                            if(isset($result)) echo $result->thumbnailURL; ?>">
                                        </div>
                                        <div class="trigger_fileUpload btn btn-default m-t-15">
                                            <span> Change Thumbnail Image </span>
                                            <input type="file" name="thumbnail" accept="image/x-png,image/jpeg" class="trigger_uploadThumbnailFile">
                                            <br>
                                        </div>

                                        <div class="trigger_pic">
                                            <img class="img-responsive img-thumbnail" id="previewPic" src="<?php 
                                            if(isset($result)) echo $result->videoPreviewURL; ?>">
                                        </div>
                                        <div class="trigger_fileUpload btn btn-default m-t-15">
                                            <span> Change Preview Image </span>
                                            <input type="file" name="preview" accept="image/x-png,image/jpeg" class="trigger_uploadPreviewFile">
                                            <br>
                                        </div>

                                        <div class="trigger_pic">
                                            <img class="img-responsive img-thumbnail" id="backgroundPic" src="<?php 
                                            if(isset($result)) echo $result->video360BackgroundURL; ?>">
                                        </div>
                                        <div class="trigger_fileUpload btn btn-default m-t-15">
                                            <span> Change Background Image </span>
                                            <input type="file" name="background" accept="image/x-png,image/jpeg" class="trigger_uploadBackgroundFile">
                                            <br>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-8 m-l-30">
                                        <!-- Category -->
                                        <div class="form-group">
                                            <label for="type">Category</label>
                                            <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" 
                                                id="category" name="category_Id">
                                                <?php foreach($type as $item) {?>
                                                    <option value="<?php echo $item->Id?>"><?php echo $item->name?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                        <!-- -->

                                        <!-- Type -->
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" 
                                                id="type" name="type_Id">
                                                <option value="Server">Server</option>
                                                <option value="Youtube" <?php if(isset($result) && $result->videoType == 'Youtube') echo 'selected'; ?>>Youtube</option>
                                            </select>
                                        </div>
                                        <!-- -->

                                        <!-- Server Video -->
                                        <div class="form-group m-b-15 server-video" style="display: <?php if(isset($result) && $result->videoType == 'Youtube') echo 'none'; else echo "block"; ?>;">
                                            <label >Please choose video file*</label>
                                            <input type="hidden" name="tmp_link" value="">
                                            <input type="file" name="link_file" class="filestyle" data-placeholder="No file" accept="*/*">
                                            <label id="selFileName">No File</label>
                                        </div>
                                        <div class="progress progress-lg m-t-20 m-b-10 form-group server-video" style="display: <?php if(isset($result) && $result->videoType == 'Youtube') echo 'none'; else echo "block"; ?>;">
                                            <div class="progress-bar progress-bar-purple" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload_progbar">
                                                0%
                                            </div>
                                        </div>
                                        <!-- -->

                                        <!-- Normal Video -->
                                        <div class="form-group normal-video", style="display: <?php if(isset($result) && $result->videoType == 'Youtube') echo 'block'; else echo "none"; ?>;">
                                            <input type="text" id="url" name="url" parsley-trigger="change" required placeholder="Enter Video URL"   
                                        class="form-control" value="<?php if(isset($result) && $result->videoType == 'Youtube') echo $result->videoURL; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- Title -->
                                        <div class="form-group">
                                            <input type="text" id="title" name="title" parsley-trigger="change" required placeholder="Enter Title"   
                                        class="form-control" value="<?php if(isset($result)) echo $result->videoTitle; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- Subtitle -->
                                        <div class="form-group">
                                            <input type="text" id="subtitle" name="subtitle" parsley-trigger="change" required placeholder="Enter Subtitle"   
                                        class="form-control" value="<?php if(isset($result)) echo $result->videoSubTitle; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- Description -->
                                        <div class="form-group">
                                            <input type="text" id="description" name="description" parsley-trigger="change" required placeholder="Enter Description" class="form-control" value="<?php if(isset($result)) echo $result->videoDescription; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- Credit -->
                                        <div class="form-group">
                                            <input type="text" id="credit" name="credit" parsley-trigger="change" required placeholder="Enter Credit"   
                                        class="form-control" value="<?php if(isset($result)) echo $result->videoCredit; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- isPaid -->
                                        <div class="form-group">
                                            <label for="type">Paid Content</label>
                                            <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" 
                                                id="paid" name="paid_id">
                                                <option value="N">No</option>
                                                <option value="Y" <?php if(isset($result) && $result->isPaid == 'Y') echo 'selected'; ?>>Yes</option>
                                            </select>
                                        </div>
                                        <!-- -->

                                        <!-- Price & Unit -->
                                        <div class="form-group price-detail" style="display: <?php if((isset($result) && $result->isPaid == 'N') || !isset($result)) echo 'none'; else echo "block"; ?>;">
                                            <input type="number" step="any" min="0" id="price" name="price" parsley-trigger="change" required placeholder="Enter Price" class="form-control" value="<?php if(isset($result) && $result->isPaid == 'Y') echo $result->price; ?>">
                                            
                                            <label for="type">Paid Unit</label>
                                            <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" 
                                                id="Unit" name="unit_id">
                                                <option value="USD">USD</option>
                                                <option value="JPY" <?php if(isset($result) && $result->PaidUnit == 'JPY') echo 'selected'; ?>>JPY</option>
                                            </select>
                                        </div>
                                        <!-- -->

                                        <!-- Capture Time -->
                                        <div class="form-group">
                                            <input type="number" id="captureTime" step="1" min="0" name="captureTime" parsley-trigger="change" required placeholder="Enter Capture Time"  class="form-control" value="<?php if(isset($result)) echo $result->captureTime; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- PinToTop -->
                                        <div class="form-group">
                                            <label for="type">PinToTop</label>
                                            <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" 
                                                id="PinToTop" name="Pin_id">
                                                <option value="N">No</option>
                                                <option value="Y" <?php if(isset($result) && $result->PinToTop == 'Y') echo 'selected'; ?>>Yes</option>
                                                
                                            </select>
                                        </div>
                                        <!-- -->

                                        <!-- Subtitle Show Time -->
                                        <div class="form-group">
                                            <input type="number" id="subtitleShowTime" step="any" min="0" name="subtitleShowTime" parsley-trigger="change" required placeholder="Enter Subtitle Show Time" class="form-control" value="<?php if(isset($result)) echo $result->videoSubtitleShowTime; ?>">
                                        </div>
                                        <!-- -->

                                        <!-- Subtitle End Time -->
                                        <div class="form-group">
                                            <input type="number" id="subtitleEndTime" step="any" min="0" name="subtitleEndTime" parsley-trigger="change" required placeholder="Enter Subtitle End Time" class="form-control" value="<?php if(isset($result)) echo $result->videoSubtitleEndTime; ?>">
                                        </div>
                                        <!-- -->

                                        <button class="btn btn-default waves-effect waves-light" type="submit" id="submitBtn">
                                            Save
                                        </button>
                                    </div>
                                </form>     
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->    
    </div> <!-- content-page -->
</div>
<script type="text/javascript">
    var $dom = {
        fileThumbleUpload: $(".trigger_uploadThumbnailFile"),
        filePreviewUpload: $(".trigger_uploadPreviewFile"),
        fileBackgroundUpload: $(".trigger_uploadBackgroundFile"),
        thumbnailPic: $("#thumbnailPic"),
        previewPic: $("#previewPic"),
        backgroundPic: $("#backgroundPic"),
        backBtn:$(".back_btn"),
        type:$("#type"),
        category:$("#category"),
        url:$("#url"),
        title:$("#title"),
        subtitle:$("#subtitle"),
        description:$("#description"),
        credit:$("#credit"),
        price:$("#price"),
        paidUnit:$("#Unit"),
        captureTime:$("#captureTime"),
        subtitleShowTime:$("#subtitleShowTime"),
        subtitleEndTime:$("#subtitleEndTime"),
        paid:$("#paid"),
        pinToTop:$("#PinToTop"),
        uploadProgbar:$("#upload_progbar"),
        linkUpload:$("#linkUpload"),
        role: $("input[name='role']"),
        submitBtn:$("#submitBtn"),
        tmpLink:$("input[name='tmp_link']"),
        Linkfile:$("input[name='link_file']"),
        selFileName:$("#selFileName")
    }
    var data_Id = "<?php echo $data_Id;?>";
    /*var type = "<?php if(isset($result)) echo $result->type_id;?>";*/
    
    function showMsg(_title, _msg) {
        swal({
            title: _title,
            text: _msg,
            type: "warning",
        });
    }

    $dom.fileThumbleUpload.on('change', function() {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#catePic");
            var reader = new FileReader();
            reader.onload = function (e) {
                $dom.thumbnailPic.attr("src", e.target.result);
                compareSubmitBtn();
            }
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            showMsg("Error", "This browser does not support FileReader.");
        }
    });

    $dom.filePreviewUpload.on('change', function() {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#catePic");
            var reader = new FileReader();
            reader.onload = function (e) {
                $dom.previewPic.attr("src", e.target.result);
                compareSubmitBtn();
            }
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            showMsg("Error", "This browser does not support FileReader.");
        }
    });

    $dom.fileBackgroundUpload.on('change', function() {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#catePic");
            var reader = new FileReader();
            reader.onload = function (e) {
                $dom.backgroundPic.attr("src", e.target.result);
                compareSubmitBtn();
            }
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            showMsg("Error", "This browser does not support FileReader.");
        }
    });

    $dom.backBtn.on('click', function() {
         location.href = "<?php echo base_url().'Cms/data/';?>"
    });
    
    $dom.Linkfile.change(function () {
        $dom.tmpLink.val($dom.Linkfile.val());
        $dom.selFileName.addClass("hide");
        compareSubmitBtn();
    });
    function initVariables() {
        var Linkfile = "<?php if(isset($result)) echo $result->fileName;?>";
        if(Linkfile !="") {
            $dom.selFileName.html(Linkfile);
        }
        $dom.tmpLink.val(Linkfile);
        compareSubmitBtn();
    }
    (function() {
        initVariables();
        $('form').ajaxForm({
            beforeSend: function() {
                $dom.uploadProgbar.attr("aria-valuenow", 0);
                $dom.uploadProgbar.text = '0%';
                $dom.uploadProgbar.css("width", '0%');
                submitBtnDisable(true);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                $dom.uploadProgbar.css("width", percentVal);  
                $dom.uploadProgbar.html(percentVal);
            },
            success: function(data, statusText, xhr) {
                $dom.uploadProgbar.attr("aria-valuenow", 100);
                $dom.uploadProgbar.text = '100%';
                $dom.uploadProgbar.css("width", '100%');  
                var status = JSON.parse(data).status;
                if(status) {
                    showMsg("Success", "Successfully..");
                    window.location.href = "<?php echo base_url().'Cms/data/'?>";
                } else {
                    showMsg("Error", "Failed.");
                }
                submitBtnDisable(false);
            },
            error: function(xhr, statusText, err) {
                // status.html(err || statusText);
                submitBtnDisable(false);
                showMsg("Error", "Failed.");
            }
        }); 
        if(type !='') {
            $dom.category.val(type);
        }
    })();

    function compareSubmitBtn() {
        if($dom.thumbnailPic.attr("src") !="" && $dom.previewPic.attr("src") != "" && $dom.backgroundPic.attr("src") != "" && $dom.title.val() != "" && $dom.subtitle.val() != "" && $dom.credit.val() != ""  && $dom.captureTime.val() != "" && $dom.subtitleShowTime.val() != "" && $dom.subtitleEndTime.val() != "" && $dom.description.val() != ""){
            if((($dom.type.val() == 'Youtube' && $dom.url.val() != "") || ($dom.type.val() == 'Server' && $dom.tmpLink.val() !="" )) && (($dom.paid.val() == 'Y' && $dom.price.val() != "") || $dom.paid.val() == 'N') )
            submitBtnDisable(false);
        }
        else
            submitBtnDisable(true);
    }

    function submitBtnDisable(disable) {
        if(disable) {
            $dom.submitBtn.addClass("disabled");
            $dom.submitBtn.prop('disabled', true);
        }
        else {
            $dom.submitBtn.removeClass("disabled");
            $dom.submitBtn.prop('disabled', false);
        }
    }

    $dom.submitBtn.on('hover', function(){
        compareSubmitBtn();
    });

    $dom.type.on('change', function(){
        compareSubmitBtn();
        if($dom.type.val() == 'Server'){
            $(".server-video").css("display", "block");
            $(".normal-video").css("display", "none");
        } else {
            $(".server-video").css("display", "none");
            $(".normal-video").css("display", "block");
        }
    });

    $dom.paid.on('change', function(){
        compareSubmitBtn();
        if($dom.paid.val() == 'Y'){
            $(".price-detail").css("display", "block");
        } else {
            $(".price-detail").css("display", "none");
        }
    });

    $dom.category.on('change', function(){
        compareSubmitBtn();
    });

    $dom.url.on('change', function(){
        compareSubmitBtn();
    });

    $dom.title.on('change', function(){
        compareSubmitBtn();
    });

    $dom.credit.on('change', function(){
        compareSubmitBtn();
    });

    $dom.price.on('change', function(){
        compareSubmitBtn();
    });

    $dom.captureTime.on('change', function(){
        compareSubmitBtn();
    });

    $dom.subtitleShowTime.on('change', function(){
        compareSubmitBtn();
    });

    $dom.subtitleEndTime.on('change', function(){
        compareSubmitBtn();
    });

    $dom.paid.on('change', function(){
        compareSubmitBtn();
    });

    $dom.category.on('change', function(){
        compareSubmitBtn();
    });

    $dom.pinToTop.on('change', function(){
        compareSubmitBtn();
    });

    $dom.paidUnit.on('change', function(){
        compareSubmitBtn();
    });

    $dom.description.on('change', function(){
        compareSubmitBtn();
    });

</script>