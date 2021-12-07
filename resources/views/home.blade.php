@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container mt-5" style="max-width: 500px">
        <form id="fileUploadForm" method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <input name="file" type="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="file">
            </div>
            <div class="d-grid mb-3">
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>
            <div class="form-group">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
            </div>
        </form>
        <div class="d-grid mb-3 mt-3" id="result"></div>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm').ajaxForm({
                    uploadProgress(event, position, total, percentComplete) {
                        let percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage + '%', function() {
                            return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete(xhr) {
                        $('.progress .progress-bar').css("width", '0%', function() {
                            return  "0%";
                        });
                        let response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            $("#result").empty();
                            $("#result").append('In the case of ' + response.employeesCount + ' employees the highest average match score is ' + response.score + '%</p>');
                            console.log(response);
                            response.matchScores.forEach((score) => {
                                $("#result").append('<p>' + score.employee1 + ' will be matched with ' + score.employee2 + '  - ' + score.score + '%</p>');
                            });
                            $('#file').val('');
                        }
                    }
                });
            });
        });
    </script>
@endsection

