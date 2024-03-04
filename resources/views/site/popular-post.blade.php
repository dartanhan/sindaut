<div class="single_sidebar" style="margin-top:10px">
     <h2><span>Vídeos</span></h2>
        <div class="latest_post_container" style="max-height: auto;overflow-y: hidden;">
            <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
            <div class="media wow fadeInDown video-gallery">
                <ul class="latest_postnav">
                    <li>
                        <!-- Video 1 -->
                        <div class="media-body">
                                <a href="{{route('site.detalhe-noticia',1)}}" class="catg_title">
                                    <i class="fa fa-volume-up"></i> Video 1 </a>
                            <div>
                            <span><i class="fa fa-calendar"></i> data 1</span>
                            </div>
                        </div>
                        <div class="video-item">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_1" frameborder="0" allowfullscreen></iframe>
                            </div>
                    </li>
                    <li>
                        <!-- Video 2 -->
                        <div class="media-body">
                                <a href="{{route('site.detalhe-noticia',1)}}" class="catg_title">
                                    <i class="fa fa-volume-up"></i> Video 2 </a>
                            <div>
                            <span><i class="fa fa-calendar"></i> data 3</span>
                            </div>
                        </div>
                        <div class="video-item">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_2" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </li>
                    <li>
                        <!-- Video 3 -->
                        <div class="media-body">
                                <a href="{{route('site.detalhe-noticia',1)}}" class="catg_title">
                                    <i class="fa fa-volume-up"></i> Video 3 </a>
                            <div>
                            <span><i class="fa fa-calendar"></i> data 3</span>
                            </div>
                        </div>
                        <div class="video-item">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_3" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
        </div>
        <!--ul class="spost_nav">
            <li>
                <div class="media wow fadeInDown video-gallery">
                    <div class="video-item">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_1" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </li>
            <div class="media wow fadeInDown">
                <a href="{{URL::asset('storage/posts/files/feaf472531f672a2cd0e7ef0024d9922.pdf')}}" target="_blank" class="media-left">
                    <img alt="" src="{{URL::asset('images/jornal.png')}}"> </a>
                <div class="media-body">
                    <a href="{{URL::asset('storage/posts/files/feaf472531f672a2cd0e7ef0024d9922.pdf')}}" target="_blank"  class="catg_title"> JORNAL DO SINDAUT 46</a>
                </div>
            </div>
            <div class="media wow fadeInDown">
                <a href="{{URL::asset('storage/posts/files/7847755032cd1cdb1bfe9f870dd1729d.pdf')}}" target="_blank" class="media-left">
                    <img alt="" src="{{URL::asset('images/jornal.png')}}"> </a>
                <div class="media-body">
                    <a href="{{URL::asset('storage/posts/files/7847755032cd1cdb1bfe9f870dd1729d.pdf')}}" target="_blank"  class="catg_title"> JORNAL DO SINDAUT 45</a>
                </div>
            </div>
            <div class="media wow fadeInDown">
                <a href="{{URL::asset('storage/posts/files/406e596a56d9c01c5faf9c408e25280c.pdf')}}" target="_blank" class="media-left">
                    <img alt="" src="{{URL::asset('images/jornal.png')}}"> </a>
                <div class="media-body">
                    <a href="{{URL::asset('storage/posts/files/406e596a56d9c01c5faf9c408e25280c.pdf')}}" target="_blank"  class="catg_title"> JORNAL DO SINDAUT 44</a>
                </div>
            </div>
            <div class="media wow fadeInDown">
                <a href="{{URL::asset('storage/posts/files/41f2fbf1d20a958513e3b6b8c61d3e13.pdf')}}" target="_blank" class="media-left">
                    <img alt="" src="{{URL::asset('images/jornal.png')}}"> </a>
                <div class="media-body">
                    <a href="{{URL::asset('storage/posts/files/41f2fbf1d20a958513e3b6b8c61d3e13.pdf')}}" target="_blank"  class="catg_title"> JORNAL DO SINDAUT 43</a>
                </div>
            </div>
        </ul-->
</div>
<style>
        .video-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .video-item {
            position: relative;
            padding-bottom: 56.25%; /* Proporção de 16:9 para vídeos */
            overflow: hidden;
        }

        .video-item iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>