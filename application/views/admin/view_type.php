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
                    <div class="col-sm-6">
                        <h4 class="page-title">Manage Category</h4>
                        <ol class="breadcrumb"> </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>CATEGORY</b></h4>
                            <p class="text-muted font-13 m-b-30"></p>
                            <table id="datatable-flexar" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Add&Edit Category</b></h4>
                            <!-- <p class="text-muted font-13 m-b-30">
                                You can input here. (You don`t have to input same price id.)
                            </p> -->
                                        
                            <form action="<?php echo base_url().'Cms_api/addEditType'?>" data-parsley-validate novalidate method="post">
                                <input type="hidden" name="type_id">
                                <div class="form-group">
                                    <label for="typename">Category Name*</label>

                                    <input type="text" name="type_english_name" parsley-trigger="change" required placeholder="Enter Category English Name" class="form-control language-input">

                                    <input type="text" name="type_simplified_chinese_name" parsley-trigger="change" required placeholder="Enter Category Simplified Chinese Name" class="form-control language-input">

                                    <input type="text" name="type_traditional_chinese_name" parsley-trigger="change" required placeholder="Enter Category Traditional Chinese Name" class="form-control language-input">

                                    <input type="text" name="type_japanese_name" parsley-trigger="change" required placeholder="Enter Category Japanese Name" class="form-control language-input">

                                    <input type="text" name="type_korean_name" parsley-trigger="change" required placeholder="Enter Category Korean Name" class="form-control language-input">

                                    <input type="text" name="type_spanish_name" parsley-trigger="change" required placeholder="Enter Category Spanish Name" class="form-control language-input">

                                    <input type="text" name="type_german_name" parsley-trigger="change" required placeholder="Enter Category German Name" class="form-control language-input">

                                    <input type="text" name="type_russian_name" parsley-trigger="change" required placeholder="Enter Category Russian Name" class="form-control language-input">

                                    <input type="text" name="type_french_name" parsley-trigger="change" required placeholder="Enter Category French Name" class="form-control language-input">

                                    <input type="text" name="type_italian_name" parsley-trigger="change" required placeholder="Enter Category Italian Name" class="form-control language-input">

                                    <input type="text" name="type_polish_name" parsley-trigger="change" required placeholder="Enter Category Polish Name" class="form-control language-input">

                                    <input type="text" name="type_portuguese_name" parsley-trigger="change" required placeholder="Enter Category Portuguese Name" class="form-control language-input">

                                    <input type="text" name="type_thai_name" parsley-trigger="change" required placeholder="Enter Category Thai Name" class="form-control language-input">

                                    <input type="text" name="type_hungarian_name" parsley-trigger="change" required placeholder="Enter Category Hungarian Name" class="form-control language-input">

                                    <input type="text" name="type_arabic_name" parsley-trigger="change" required placeholder="Enter Category Arabic Name" class="form-control language-input">

                                </div>
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Save
                                    </button>
                                    <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                        Clear
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->    
    </div> <!-- content-page -->
</div>
        <!-- END wrapper -->

<style type="text/css">

.language-input{
    margin-bottom: 5px;
}

</style>

<script type="text/javascript">
    var table;
    var tableName = "<?php global $MYSQL; echo $MYSQL['_categoriesDB']?>";
    var $dom = {
        typeId:$("input[name=type_id]"),
        typeEnglishName:$("input[name=type_english_name]"),
        typeSimplifiedChineseName:$("input[name=type_simplified_chinese_name]"),
        typeTraditionalChineseName:$("input[name=type_traditional_chinese_name]"),
        typeJapaneseName:$("input[name=type_japanese_name]"),
        typeKoreanName:$("input[name=type_korean_name]"),
        typeSpanishName:$("input[name=type_spanish_name]"),
        typeGermanName:$("input[name=type_german_name]"),
        typeRussianName:$("input[name=type_russian_name]"),
        typeFrenchName:$("input[name=type_french_name]"),
        typeItalianName:$("input[name=type_italian_name]"),
        typePolishName:$("input[name=type_polish_name]"),
        typePortugueseName:$("input[name=type_portuguese_name]"),
        typeThaiName:$("input[name=type_thai_name]"),
        typeHungarianName:$("input[name=type_hungarian_name]"),
        typeArabicName:$("input[name=type_arabic_name]")
    }
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
                    targets: [ 1 ], 
                    orderable: true, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ 2 ], 
                    orderable: false, //set not orderable
                    className: "dt-center"
                },
                { 
                    targets: [ -1 ], //last column
                    orderable: false, //set not orderable
                    className: "actions dt-center"
                }
            ],
            ajax: {
                url: "<?php echo site_url('Cms_api/getType')?>",
                type: "POST",
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
    clearForm();

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }
    var EditType = function(_idx) {
        $.ajax({
            url : "<?php echo site_url('Cms_api/getDataById')?>",
            data: {Id:_idx, tbl_Name: tableName},
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                // reload_table();
                $dom.typeId.val(data.Id);
                $dom.typeEnglishName.val(data.category_name);
                $dom.typeSimplifiedChineseName.val(data.zh_CN);
                $dom.typeTraditionalChineseName.val(data.zh_TW);
                $dom.typeJapaneseName.val(data.ja);
                $dom.typeKoreanName.val(data.ko);
                $dom.typeSpanishName.val(data.es);
                $dom.typeGermanName.val(data.de);
                $dom.typeRussianName.val(data.ru);
                $dom.typeFrenchName.val(data.fr);
                $dom.typeItalianName.val(data.it);
                $dom.typePolishName.val(data.pl);
                $dom.typePortugueseName.val(data.pt_PT);
                $dom.typeThaiName.val(data.th);
                $dom.typeHungarianName.val(data.hu);
                $dom.typeArabicName.val(data.ar);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Error!", "", "error");  
            }
        });
    }
    
    function clearForm(){
        $dom.typeId.val("");
        $dom.typeEnglishName.val("");
        $dom.typeSimplifiedChineseName.val("");
        $dom.typeTraditionalChineseName.val("");
        $dom.typeJapaneseName.val("");
        $dom.typeKoreanName.val("");
        $dom.typeSpanishName.val("");
        $dom.typeGermanName.val("");
        $dom.typeRussianName.val("");
        $dom.typeFrenchName.val("");
        $dom.typeItalianName.val("");
        $dom.typePolishName.val("");
        $dom.typePortugueseName.val("");
        $dom.typeThaiName.val("");
        $dom.typeHungarianName.val("");
        $dom.typeArabicName.val("");
    }

    var msg = "<?php if($this->session->flashdata('messagePr')) { echo $this->session->flashdata('messagePr'); 
                    $this->session->unset_userdata('messagePr');} else echo 'no'?>";
    if(msg !='no') {
        if(msg.includes('Successfully')) 
            $.Notification.notify('success','bottom right','Success', msg);
        else
            $.Notification.notify('error','bottom right','Error', msg);
    }

    $('.dt-buttons').css('display', 'none'); // remove Copy, CSV, Excel, Print, etc.

</script>