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
                            <button type="button" class="btn btn-default waves-effect waves-light" id="addBtn" 
                                aria-expanded="false"><span class="m-r-5"><i class="fa fa-plus"></i></span>Add</button>
                        </div>
                        <h4 class="page-title">Manage Videos</h4>
                        <ol class="breadcrumb"> </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-sm-2">
                        <select class="selectpicker show-tick form-control" data-style="btn-default btn-custom" id="main_type" name="main_type">
                            <option value="-1">All</option>
                            <?php foreach($type as $item) {?>
                                <option value="<?php echo $item->Id?>"><?php echo $item->name?></option>
                            <?}?>
                        </select>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b></b></h4>
                            <p class="text-muted font-13 m-b-30"></p>
                            <table id="datatable-flexar" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>VideoURL</th>
                                        <th>ThumbURL</th>
                                        <th>PreviewURL</th>
                                        <th>BackgroundURL</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Description</th>
                                        <th>Duration</th>
                                        <th>Credit</th>
                                        <th>FileName</th>
                                        <th>PaidContent</th>
                                        <th>Price</th>
                                        <th>PaidUnit</th>
                                        <th>CaptureTime</th>
                                        <th>PinToTop</th>
                                        <th>VideoViews</th>
                                        <th>VideoSubtitleShowTime</th>
                                        <th>VideoSubtitleShowTime</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>VideoURL</th>
                                        <th>ThumbURL</th>
                                        <th>PreviewURL</th>
                                        <th>BackgroundURL</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Description</th>
                                        <th>Duration</th>
                                        <th>Credit</th>
                                        <th>FileName</th>
                                        <th>PaidContent</th>
                                        <th>Price</th>
                                        <th>PaidUnit</th>
                                        <th>CaptureTime</th>
                                        <th>PinToTop</th>
                                        <th>VideoViews</th>
                                        <th>VideoSubtitleShowTime</th>
                                        <th>VideoSubtitleShowTime</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->    
    </div> <!-- content-page -->
</div>
        <!-- END wrapper -->
<form action="" id="goForm" method="POST"> 
    <input type="hidden" name="data_Id" value="">;
</form>

<script type="text/javascript">
    var table;
    var tableName = "<?php global $MYSQL; echo $MYSQL['_dataDB']?>";
    var _type = "-1";
    var handleDataTableButtons = function() {
        table = $("#datatable-flexar").DataTable({
            dom: "lfBrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
            responsive: !0,
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            language: {
                paginate: {
                      next: '<i class="fa fa-angle-right"></i>',
                      previous: '<i class="fa fa-angle-left"></i>',
                      first: '<i class="fa fa-angle-double-left"></i>',
                      last: '<i class="fa fa-angle-double-right"></i>'
                }
            },
            //Set column definition initialisation properties.
            columnDefs: [
                { 
                    targets: [ 0 ], //first column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 1 ], //Category column
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 2 ], //Type Name column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 3 ], //video URL column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 4 ], //thumbnail URL column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 5 ], //preview URL column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 6 ],  //background URL column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 7 ], //video Title column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 8 ], //video Subtitle column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 9 ], //video Description column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 10 ], //video Duration column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 11 ], //video Credit column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 12 ], //file Name column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 13 ], //isPaid column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 14 ], //price column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 15 ], //PaidUnit column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 16 ], //capture Time column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 17 ], //Pin To Top column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 18 ], //Video View column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 19 ], //subtitle Show Time column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 20 ], //subtitle End Time column 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                {
                    targets: [ -1 ], 
                    orderable: false, //set not orderable
                    className: "actions"
                }
            ],
            ajax: {
                url: "<?php echo site_url('Cms_api/getData')?>/"+ _type,
                type: "POST"
            },
        })
    },
    TableManageButtons = function() {
        return {
            init: function() {
                handleDataTableButtons()
            }
        }
    }();

    TableManageButtons.init();
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }
    function PlayVideo(_idx) {
        goTo(_idx, 'play');
    }
    function EditData(_idx) {
        goTo(_idx, 'edit');
    }
    var RemoveData = function(_idx) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover Marker and Overlay files!",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-white btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Remove',
            closeOnConfirm: false
        }, function(isConfirm) {
            if(isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('Cms_api/delData')?>",
                    data: {Id:_idx},
                    type: "POST",
                    success: function(data)
                    {
                        if(data.includes("true")) {
                            reload_table();
                            swal("Removed!", "", "success");
                        } else {
                            swal("Error!", "", "error");  
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        // alert('Error get data from ajax');
                        swal("Error!", "", "error");  
                    }
                });
            }
        });
    }
    var $dom = {
        goForm:$('#goForm'),
        addBtn:$('#addBtn'),
        dataId:$("input[name=data_Id]"),
        mainType:$("#main_type")
    }
    $dom.mainType.on('change', function (e) {
        _type = $dom.mainType.val();
        table.ajax.url("<?php echo site_url('Cms_api/getData')?>/" + _type).load();
    });
    $dom.addBtn.on('click', function() {
        goTo('', 'edit');
    })
    function UpdateAvaiable(_idx) {
        $.ajax({
            url : "<?php echo site_url('Cms_api/ajaxOnOff')?>",
            data: {Id:_idx, field: 'isactive', tbl_Name: tableName},
            type: "POST",
            success: function(data)
            {
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // alert('Error get data from ajax');
                swal("Error!", "", "error");  
            }
        });
    }
    function goTo(idx='') {
        if(idx !='')
            $dom.dataId.val(idx);
        $dom.goForm.submit();
    }
    function goTo(_idx='', _kind) {
        if(_kind == 'edit') {
            $dom.goForm.attr("action", "<?php echo site_url('Cms/add_edit_data')?>");
        } else if(_kind == 'play') {
            $dom.goForm.attr("action", "<?php echo site_url('Cms/play_video')?>");
        }
        if(_idx !='')
            $dom.dataId.val(_idx);
        $dom.goForm.submit();
    }

    $('.dt-buttons').css('display', 'none'); // remove Copy, CSV, Excel, Print, etc.

</script>
        