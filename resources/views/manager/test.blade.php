<x-app-manager-layout>

    <x-slot name="js">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    </x-slot>

    <x-slot name="css">
    </x-slot>

    <x-slot name="view_name">
       テスト
    </x-slot>

    <div class="main-contents">
        <div class="dashboard-contents" style="width:1000px">
            <iframe id="vimeo-player" src="https://player.vimeo.com/video/1072769768?api=1&player_id=vimeo-player"
                    width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
        </div>
    </div>

    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        let iframe = document.querySelector('#vimeo-player');
        let player = new Vimeo.Player(iframe);
        let sentPercents = [];
        let propertyPercent = 0;

        player.on('timeupdate', function(data) {
            const duration = data.duration;
            let currentTime = data.seconds;
            let currentPercent = Math.floor((currentTime / duration) * 100);

            let nowPercent = 0;
            // 80%以下の場合は5％単位で送る
            if (currentPercent <= 80) {
                nowPercent = Math.floor(currentPercent / 5) * 5;
            } else {
                nowPercent = Math.floor(currentPercent / 1) * 1;
            }

            // 前回よりも再生率が高い場合
            if (propertyPercent < nowPercent) {
                propertyPercent = nowPercent
                console.log(nowPercent + '%')
                // sendProgressToLaravel(nowPercent)
            }
        });

        function sendProgressToLaravel(percent) {
            fetch('/video/progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ percent: percent })
            });
        }
    </script>


</x-app-manager-layout>

