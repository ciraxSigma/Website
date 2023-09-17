<x-login-layout>

    <h1 class="doucments-heading">My Documents</h1>

    <div class="documents-list-wrapper">

        @foreach($files as $file)

            <div class="document-row">
                <p>{{$file}}</p>
                
                <a href="/documents/download?file={{$file}}">
                    <button class="download-button">Download</button>
                </a>

            </div>


        @endforeach

    </div>

</x-login-layout>