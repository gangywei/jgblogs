<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JianGang</title>
    <link rel="stylesheet" href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
</head>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{date('H:i',time())}}</span>

            <h3 class="timeline-header"><a href="#">建刚</a> 向你发送邮件</h3>

            <div class="timeline-body">
                <h1><a href="{{url('')}}">忘眼欲川</a>的{{$content}}</h1>
            </div>
        </div>
</html>