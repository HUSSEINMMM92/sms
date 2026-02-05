<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("exam_result/add");
$can_edit = ACL::is_allowed("exam_result/edit");
$can_view = ACL::is_allowed("exam_result/view");
$can_delete = ACL::is_allowed("exam_result/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Exam Result</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['']) ? urlencode($data['']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-ER_id">
                                        <th class="title"> Er Id: </th>
                                        <td class="value"> <?php echo $data['ER_id']; ?></td>
                                    </tr>
                                    <tr  class="td-Sub_ID">
                                        <th class="title"> Sub Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Sub_ID']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="Sub_ID" 
                                                data-title="Enter Sub Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Sub_ID']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-E_id">
                                        <th class="title"> E Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['E_id']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="E_id" 
                                                data-title="Enter E Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['E_id']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-class_id">
                                        <th class="title"> Class Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['class_id']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="class_id" 
                                                data-title="Enter Class Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['class_id']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Std_id">
                                        <th class="title"> Std Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Std_id']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="Std_id" 
                                                data-title="Enter Std Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Std_id']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-marks">
                                        <th class="title"> Marks: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['marks']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="marks" 
                                                data-title="Enter Marks" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['marks']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-teacher_id">
                                        <th class="title"> Teacher Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['teacher_id']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="teacher_id" 
                                                data-title="Enter Teacher Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['teacher_id']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-Academic_year_id">
                                        <th class="title"> Academic Year Id: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['Academic_year_id']; ?>" 
                                                data-pk="<?php echo $data[''] ?>" 
                                                data-url="<?php print_link("exam_result/editfield/" . urlencode($data['ER_id'])); ?>" 
                                                data-name="Academic_year_id" 
                                                data-title="Enter Academic Year Id" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['Academic_year_id']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <div class="dropup export-btn-holder mx-1">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-save"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                    <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                        <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                        </a>
                                        <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                        <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                            <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                            </a>
                                            <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                            <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                </a>
                                                <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                    </a>
                                                    <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                    <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                        <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <!-- Empty Record Message -->
                                            <div class="text-muted p-3">
                                                <i class="fa fa-ban"></i> No Record Found
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
