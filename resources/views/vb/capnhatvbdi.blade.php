@extends('templates.master')
@section('title'){{$title}} - {{TITLE}}@stop
@section('content')
    <h3>{{$title}}</h3>
    {!! HTML::script('assets/ext/jquery-validation/dist/jquery.validate.js') !!}
    {!! HTML::script('assets/ext/jquery-validation/dist/additional-methods.min.js') !!}
    {{--Chosen jquery--}}
    {!! HTML::script('assets/ext/chosen/chosen.jquery.js') !!}
    {!! HTML::style('assets/ext/chosen/chosen.css') !!}
    {!! HTML::script('assets/ext/jquery.blockUI.js') !!}
    <div class="row cells12 no-margin">
        <ul class="inline-list unstyled-list">
            @if(!empty($prevRecord))
                <li><a
                            href="{{url(Request::segment(1) .'/'.Request::segment(2).'/'.$prevRecord.'/'.Request::segment(4))}}"><i
                                class="fa fa-arrow-left"></i> Trước</a></li>@endif
            @if(!empty($nextRecord))
                <li><a href="{{url(Request::segment(1) .'/'.Request::segment(2).'/'.$nextRecord.'/'.Request::segment(4))}}">Sau
                        <i class="fa fa-arrow-right"></i></a></li>@endif
        </ul>
    </div>
    {{alert()}}
    @if($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <p class="notes"><span class="fg-red">*</span> Thông tin bắt buộc</p>
    {!! Form::open(['url' => Request::segment(1).'/update/'.$getVb['id'],'method'=>'post','id'=>'form', 'files' => TRUE,'class'=>'bg-white padding10 shadow']) !!}
    <div class="form-group">
        <label for="nam" class="required">Năm</label>

        <select name="nam" class="form-control" data-placeholder="Năm đi">
            @for($i = date('Y'); $i >= date('Y') - 3; $i--)
                @if((Input::has('nam') && Input::post('nam') == $i) || $getVb['nam']==$i)
                    <option selected value="{{$i}}">{{$i}}</option>
                @else
                    <option value="{{$i}}">{{$i}}</option>
                @endif
            @endfor
        </select>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label for="loai_van_ban" class="required">Loại văn bản</label>

            <select name="loai_van_ban" class="form-control" data-placeholder="Loại văn bản">
                <option value=""></option>
                @foreach($list_vb as $lv)
                    @if((Input::old('loai_van_ban') == $lv['id'])||$getVb['loai_van_ban']==$lv['id'])
                        <option selected value="{{$lv['id']}}">{{$lv['ten_loai']}}</option>
                    @else
                        <option value="{{$lv['id']}}">{{$lv['ten_loai']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        @if(Request::segment(1)=='vb_mat_di')
            <div class="col-lg-6">
                <label for="do_mat" class="required">Độ mật</label>

                <select name="do_mat" class="form-control" data-placeholder="Độ mật">
                    <option value=""></option>
                    @foreach($ds_do_mat as $dm)
                        @if((Input::old('do_mat') && Input::old('do_mat') ==$dm['id'])||$getVb['do_mat']==$dm['id']){
                        <option selected value="{{$dm['id'] }}">{{$dm['ten_loai_mat']}}</option>
                        @else
                            <option value="{{$dm['id'] }}">{{$dm['ten_loai_mat']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::label('so_di','Số và ký hiệu',['class'=>'required']) !!}
                    <input type="text" name="so_di" class="form-control" readonly value="{{$getVb['so_di']}}"/>
                </div>
                <div class="col-lg-12">
                    <label for="ngay_van_ban" class="required">Ngày văn bản</label>

                    <input type="text" name="ngay_van_ban" id="ngay_van_ban" class="form-control" value="{{implode('/',array_reverse(explode('-',$getVb['ngay_van_ban'])))}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <label class="required" for="trich_yeu">Trích yếu</label>

            <textarea name="trich_yeu" id="trich_yeu" class="form-control" rows="5">{{$getVb['trich_yeu']}}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <label class="required" for="don_vi_nguoi_nhan_ban_luu">Đơn vị phát hành</label>

            <select name="don_vi_nguoi_nhan_ban_luu" id="don_vi_nguoi_nhan_ban_luu" class="form-control" data-placeholder="Đơn vị lưu">
                <option value=""></option>
                @foreach($list_dv as $dv)
                    @if((Input::old('don_vi_nguoi_nhan_ban_luu') && Input::old('don_vi_nguoi_nhan_ban_luu') == $dv['id']) || $getVb['don_vi_nguoi_nhan_ban_luu'] == $dv['id'])
                        <option selected value="{{$dv['id']}}">{{$dv['ten_don_vi']}}</option>
                    @else
                        <option value="{{$dv['id']}}">{{$dv['ten_don_vi']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-lg-4">
            <label for="nguoi_ky">Người ký</label>

            <input type="text" name="nguoi_ky" class="form-control" id="nguoi_ky" value="{{$getVb['nguoi_ky']}}"/>
        </div>
        <div class="col-lg-4">
            <label class="required" for="noi_nhan">Nơi nhận</label><span class="fg-red pull-right" title="Thêm nhanh"
                                                                         id="addTg" style="cursor: pointer">Thêm nhanh <i class="fa fa-plus"></i></span>

            <select name="noi_nhan[]" id="noi_nhan" multiple class="form-control" data-placeholder="Có thể chọn nhiều nơi nhận">
                <option value=""></option>
                <?php
                $arrTg = explode('|',
                                 $getVb['noi_nhan']);
                asort($arrTg);
                $i = 0;
                foreach($ds_tg as $nn){
                    if($i < count($arrTg) && $nn['id'] == $arrTg[$i]){
                        echo '<option selected value="' . $nn['id'] . '">' . $nn['ten_tac_gia'] . '</option>';
                        $i++;
                    }else{
                        echo '<option value="' . $nn['id'] . '">' . $nn['ten_tac_gia'] . '</option>';
                    }

                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <input type="file" name="tap_tin" class="file" accept="application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/msword">
            <div class="input-group col-xs-12">
                <input type="text" class="form-control input-lg" disabled placeholder="Tập tin">
                <span class="input-group-btn">
                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Duyệt</button>
                      </span>
            </div>
            @if(file_exists(str_replace('/','\\',base_path().'\\'.$getVb['tap_tin'] .  $getVb['ten_tap_tin'])))<span id="delFile" class="pull-right">
                        <a href="#" id="del_file">Xóa tập tin này <i class="fa fa-remove"></i></a>
                        <script>
                            $('#del_file').click(function () {
                                $.ajax({
                                    type: 'POST', url: '{{url(Request::segment(1).'/deletefile')}}',
                                    data: {
                                        id: '{{Request::segment(3)}}'
                                    },
                                    cache: false,
                                    beforeSend: function () {
                                        $('#loading').show();
                                    },
                                    success: function (msg) {
                                        $('#loading').hide();
                                        if (msg == 1) {
                                            $('span#delFile').html('');
                                        } else {
                                            alert(msg);
                                        }

                                    }
                                });

                                return false;
                            });
                        </script>
                        </span> @endif
        </div>
        <div class="col-xs-3">
            <label for="so_luong_ban">Số lượng bản</label>

            <input type="number" name="so_luong_ban" id="so_luong_ban" class="form-control" value="{{$getVb['so_luong_van_ban']}}"/>
        </div>
        <div class="col-xs-3">
            <label for="quyen_truy_cap" class="required">Quyền truy cập</label>

            <select name="quyen_truy_cap" id="quyen_truy_cap" data-placeholder="Quyền truy cập" class="form-control quyen_truy_cap">
                <option value=""></option>
                @foreach($ds_phan_quyen as $row)
                    @if((Input::old('quyen_truy_cap') && Input::old('quyen_truy_cap') == $row['level']) || $getVb['quyen_truy_cap']==$row['level'])
                        <option selected value="{{$row['level']}}">{{$row['label']}}</option>
                    @else
                        <option value="{{$row['level']}}">{{$row['label']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-xs-3">
            <label for="ghi_chu">Ghi chú</label>
            <textarea name="ghi_chu" class="form-control">{{$getVb['ghi_chu']}}</textarea>
        </div>
    </div>

    {{button(url(Request::segment(1)))}}
    {!! Form::close() !!}
    <script>
        $('#noi_nhan').chosen();
        $("#form").validate({
            rules: {
                so_di: "required",
                ngay_van_ban: "required",
                trich_yeu: "required",
                @if(Request::segment(1)=='vb_mat_di')
                do_mat: "required",
                @endif
                noi_nhan: "required",
                loai_van_ban: "required",
                quyen_truy_cap: "required",
                so_luong_ban: "number",
                don_vi_nguoi_nhan_ban_luu: {
                    required: true,
                    number: true
                },
            },
            errorElement: "div"
        });
        $('#ngay_van_ban').datepicker({dateFormat: 'dd/mm/yy', firstDay: 1, showButtonPanel: true, changeMonth: true, changeYear: true});
        $(document).ready(function () {
            $("#addTg").click(function () {
                $.blockUI({
                    message: "<div class=\"padding20\"><form method='post' name='addTg'><div class=\"row\"><label for='ten_tac_gia'>Tên tác giả: </label><input type='text' name='ten_tac_gia'/></div><button id=\"addTg\" class=\"btn bg-red fg-white\" type=\"submit\">Thêm mới</button></form><script>$(document).ready(function(){$(\"#addTgAjax\").validate({rules:{ten_tac_gia:\"required\"},submitHandler:function(a){$.ajax({type:\"POST\",url:\"{{url('tacgia/insertajax')}}\",data:{ten_tac_gia:$('input[name=\"ten_tac_gia\"]').val()},cache:!1,beforeSend:function(){$(\"#loading\").show()},success:function(a){$(\"#loading\").hide(),$(\"#overlay\").remove();var b=a.split(\"_\");$(\"#tac_gia\").prepend('<option selected value=\"'+b[0]+'\">'+b[1]+\"</option>\"),$(\".chosen-single span\").text($('input[name=\"ten_tac_gia\"]').val()),$(\"#tac_gia\").trigger(\"chosen:updated\"),$(\"#dialog\").attr(\"style\",\"left: 0px; right: 0px; width: auto; height: auto; display: none; top: 145px;\"),$(\".dialog-overlay\").remove()}})},errorElement:\"div\"})});<\/script></div>",
                    onOverlayClick: $.unblockUI
                });
            });
        });
    </script>
@stop