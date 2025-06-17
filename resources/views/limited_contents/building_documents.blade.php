<x-limited-contents-layout :building="$building" :contentsMenu="$contents_menu" :appLogId="$app_log_id">
    <x-slot name="css">
    </x-slot>

    <x-slot name="js">
    </x-slot>

    <div class="main-contents">

        <iframe src="/pdfjs/web/viewer.html?file=../../sample.pdf&disablePrint=true&disableDownload=true"
                id="frame-area"></iframe>

    </div>
</x-limited-contents-layout>

<style>
    .main-contents{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #frame-area {
        width: 95%;
        height: 95%;
    }
    #downloadButton {
        display: none;
    }
</style>
                