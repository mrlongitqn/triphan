@extends('layouts.print_layout')
@push('page_css')
    <style>
        body {
            font-family: "Times-Roman", serif;
            font-size: 1.2rem;
        }

        p {
            margin-bottom: 0.4rem;
        }

        table, tr, td {

            border: 1px solid !important;
        }

        table th {
            background: #5fa2db;
            font-weight: bold;
            border: 1px solid #000;
        }

        table {
            width: 100%
        }

        table td, table th {
            padding: 0 4px;
        }


        .text-center {
            text-align: center;
        }

        #footer p {
            margin-bottom: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: bold;
        }

        .col-12 {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: justify;
        }
    </style>
@endpush
@php
    $current = \Illuminate\Support\Facades\Date::now();
    $total = 0;
@endphp
@section('body')

    <div class="invoice p-3 mb-3">

        <div class="row">
            <div class="col-12" style="text-align: center">
                <h3>
                    CÔNG TY TNHH GIÁO DỤC TRÍ PHAN
                </h3>
                <h5>
                    ĐC: 32-34 Bàu Năng 2, P.Hòa Minh, Q.Liên Chiểu, TP.Đà Nẵng
                </h5>
                <h5>MST: 0401 828 513 * ĐT: 0905 290 857</h5>

            </div>
        </div>
        <h2 class="text-center mt-3">THÔNG BÁO </h2>
        <p class="text-center">(Về kết quả học tập và học phí tới ngày {{$current->format('d/m/Y')}})
        <div class="row">
            <div class="col-12">
                <p><b> Kính gửi:</b> Phụ huynh học sinh <strong>{{$student->fullname}}</strong></p>
                <p>Trước hết, thay mặt <strong>Trung tâm Giáo dục Trí Phan</strong> chúng tôi xin gửi lời cảm ơn đến phụ
                    huynh đã tin
                    tưởng gửi gắm con em mình theo học tại đây. Kính chúc gia đình mình luôn được sức khỏe, bình an và
                    hạnh phúc. </p>
                <p>Tiếp đến, chúng tôi xin thông tin đến quý phụ huynh về kết quả học tập của con em mình, cùng với tiến
                    độ học phí như sau: </p>
            </div>
            <div class="col-12">
                <p><b>1. Kết quả học tập của em đến ngày {{$current->format('d/m/Y')}} tại Trung tâm Giáo dục Trí
                        Phan. </b></p>
                <table>
                    <tr>
                        <th width="40px">STT</th>
                        <th width="250px">Môn học</th>
                        <th width="250px">Đợt</th>
                        <th width="250px">Điểm</th>
                        <th>Nhận xét từ giáo viên</th>
                    </tr>

    <?php $i = 1; ?>
                    @foreach($marks as $key => $mark)
                        <tr>
                            <td class="text-center">{{$i++}}</td>
                            <td>{{$courses[$mark->course_id]->course}}</td>
                            <td>
                                {{$sessionMarks[$mark->session_mark_id]->session}}
                            </td>
                            <td>
                                @php
                                $markTypeDetail = $markTypeDetails->where('mark_type_id',$courses[$mark->course_id]->mark_type_id);

                                @endphp
                                @foreach ($markTypeDetail as $mType)
                                {{$mType->column_name}}: {{$mark['score'.$mType->column_number]}};
                                @endforeach
                            </td>
                            <td>
                                {{$mark['note']}}
                            </td>
                        </tr>
                    @endforeach

                </table>
                <p><i>Mọi thắc mắc liên quan về kết quả học tập, quý phụ huynh/học viên vui lòng liên hệ qua kênh:<br/>
                        <span style="margin-left: 40px">  Zalo:<b>0986.408.407</b></span><br/>
                        <span style="margin-left: 40px"> Email: <b>triphanclc@gmail.com</b></span>
                    </i>
                </p>
            </div>

            <div class="col-12">
                <p><b>2. Thông tin học phí của em đến ngày {{$current->format('d/m/Y')}} tại Trung tâm Giáo dục Trí
                        Phan.</b></p>
                <table>
                    <tr>
                        <th width="40px">STT</th>
                        <th width="250px">Môn học</th>
                        <th>Tình trạng</th>
                        <th>Học phí</th>
                    </tr>
                    @foreach($courses as $key => $course)
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            <td>{{$course->course}}</td>
                            <td>
                                @if($course->fee_status==1)
                                    Đã hoàn tất
                                @else
                                    @php
                                        $total = $total + $course->debt_amount
                                    @endphp
                                    Đang nợ: {{number_format($course->debt_amount) }}
                                    <br/>
                                    Nợ từ tháng ({{$course->debt_month_start->format('m-Y')}})
                                @endif
                            </td>

                            <td>
                                {{number_format($course->fee) }} VNĐ/Tháng
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-12">
                <h4>Học phí còn nợ : <strong>{{number_format($total)}} VNĐ</strong></h4>
                <p>Trong thời gian 2 tuần, quý phụ huynh vui lòng hoàn thành học phí học tập. Sau thời gian này, văn
                    phòng Trí Phan sẽ chốt danh sách học sinh cho giáo viên phụ trách để điểm danh cũng như việc đưa các
                    em vào lớp. </p>
                <p><b>*Hình thức thanh toán học phí*</b>: nộp trực tiếp tại Văn phòng Trung tâm hoặc chuyển khoản học
                    phí
                    (Internet Banking)</p>
                <p>
                    Thông tin chuyển khoản gửi vào một trong hai tài khoản bên dưới cần ghi rõ:<br/> <b>HỌ TÊN HỌC SINH
                        VÀ
                        LỚP</b>;
                    VÍ DỤ: <b>NGUYEN-VAN-HOANG-LOP-IELTS-HP Thang8.9</b>
                </p>

                <p>
                <h4>Thông tin chuyển khoản</h4>
                <img src="{{url('/qr.jpg')}}" style="width: 200px; float: left; margin-right: 30px"/>
                <p>

                    Ngân hàng TMCP Công thương Việt Nam Vietinbank<br/>
                    STK: <b>0975 168 408</b><br/>
                    Chủ tài khoản: Le Thi Kim Tuyet Chi nhánh VietinBank Bắc Đà Nẵng<br/>
                    <i>
                        Quý phụ huynh lưu ý sau khi chuyển khoản trực tuyến hoặc chuyển khoản ở ngân hàng thành công,
                        quý
                        phụ huynh vui lòng chụp ảnh thông tin chuyển khoản gửi trực tiếp về Zalo: <b>0986.408.407</b> để
                        được trung
                        tâm xác nhận

                    </i>
                    <br/>
                    Nếu có thắc mắc liên quan đến học phí, quý phụ huynh/học viên vui lòng liên hệ qua số điện thoại:
                    0975.168.408 (chị Tuyết – Quản lý) để được hỗ trợ.
                </p>
                </p>

            </div>
            <div class="col-12">
                <h4 class="text-center"><i>Trân trọng!</i></h4>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        setTimeout(function () {
            window.print();
        }, 500);
        window.onfocus = function () {
            setTimeout(function () {
                window.close();
            }, 500);
        }
    </script>
@endpush
