@extends("layouts.app")

@section("content")
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="card card-xl-stretch mb-xl-8">
				<!--begin::Header-->
				<div class="card-header align-items-center border-0 mt-4">
					<h3 class="card-title align-items-start flex-column">
						<span class="fw-bolder mb-2 text-dark">{{__('form.Log') }}</span>
						<span class="text-muted fw-bold fs-7">{{$total_logs}} {{__('form.Total log') }}</span>
					</h3>
					</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body pt-5">
					<!--begin::Timeline-->
					<div class="timeline-label">
						<!--begin::Item-->
						@foreach($logs_array as $log)
							<div class="timeline-item">
								<!--begin::Label-->
								<div class="timeline-label fw-bolder text-gray-800 fs-8">{{$log->created_at->format('h:i a')}}</div>
								<!--end::Label-->
								<!--begin::Badge-->
								<div class="timeline-badge">
									<i class="fa fa-genderless text-{{$log->status}} fs-1"></i>
								</div>
								<!--end::Badge-->
								<!--begin::Text-->
								<div class="fw-mormal timeline-content text-muted ps-3">{{$log->message}} <br> <b>{{$log->created_at->format('d/m/Y')}}</b></div>
								<!--end::Text-->
							</div>
						@endforeach
					</div>
					<!--end::Timeline-->
				</div>
				<!--end: Card Body-->
			</div>
		</div>
	</div>
</div>

@endsection

