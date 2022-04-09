<div class="{{ !isset($itemTour) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemTour) ? $itemTour : '' }}">
    <div class="project-wrap">
        <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" class="img"
           style="background-image: url({{ $tour->t_image ? asset(pare_url_file($tour->t_image)) : asset('admin/dist/img/no-image.png') }});">
            <span class="price">{{ number_format($tour->t_price_adults,0,',','.') }} vnd/người</span>
        </a>
        <div class="text p-4">
            <span class="days">{{ $tour->t_schedule }}</span>
            <h3>
                <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" title="{{ $tour->t_title }}">
                    {{ the_excerpt($tour->t_title, 100) }}
                </a>
            </h3>
            <p class="location"><span class="fa fa-map-marker"></span> Từ : {{ isset($tour->t_starting_gate) ? $tour->t_starting_gate : '' }}</p>
            <p class="location"><span class="fa fa-calendar-check-o"></span> Khởi hành : {{ $tour->t_start_date  }}</p>
            <?php $number = $tour->t_number_guests - $tour->t_number_registered ?>
            <p class="location"><span class="fa fa-user"></span> Số chỗ : {{ $tour->t_number_guests  }}</p>
            <p class="location"><span class="fa fa-user"></span> Số chỗ còn trống : {{ $number > 0 ? $number : 0  }}</p>
            {{--<ul>--}}
            {{--<li><i class="fa fa-user" aria-hidden="true"></i> 2</li>--}}
            {{--<li><i class="fa fa-user" aria-hidden="true"></i> 3</li>--}}
            {{--</ul>--}}
        </div>
    </div>
</div>