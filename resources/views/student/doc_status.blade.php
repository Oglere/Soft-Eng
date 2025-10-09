@extends('layout.student')
<link rel="stylesheet" href="{{ asset('') }}">
<style>
    .right h1 {
        font-weight: bold;
        color: black;
        font-size: 40px;
        text-align: center;
    }
	.message-card {
		width: 1080px;   
		height: 80px;
		border-radius: 12px;
		padding: 25px;
		margin: 10px;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
		align-items: center;
		background: #f5f5f5;
		color: #000000;
		border: 1px solid black;
	}
	.message-card:hover{
		cursor: pointer;
		box-shadow: 3px 3px 1px #04128e;
		transition: 0.8s ease;
	}
	.left-col,
	.right-col {
		display: flex;
		flex-direction: column;
		gap: 4px;
	}
	.left-col a {
		font-weight: bold;
		font-size: 14px;
		color: #000;
		text-decoration: underline;
	}
	.left-meta,
	.right-meta {
		display: flex;
		align-items: center;
		gap: 4px;
		font-size: 12px;
		color: #000;
	}
	.study-sections {
		margin-top: 50%;
		padding: 0 20px;
		text-align: center;
	}
	.study-sections h2 {
		font-weight: bold;
		color: black;
		margin: 40px 0;
		font-size: 24px;
	}
</style>

@section('right')
    <h1>
        STATUS OF SUBMITTED DOCUMENTS
    </h1>
    <div>
        @forelse($submissions as $submission)
            <div class="message-card">
                <!-- LEFT -->
                <div class="left-col">
                        <a href="{{ route('student.view-status', ['id' => $submission->document_id]) }}">
                        {{ $submission->title ?? 'Untitled Document' }}
                    </a>
                        <div class="left-meta">
                            <span style="font-size: 14px;">
                                {{ \Carbon\Carbon::parse($submission->date_submitted)->format('M d, Y') }}
                            </span>
                        </div>
                </div>

                <!-- RIGHT -->
                <div class="right-col">
                    @if($submission->status === 'pending')
                            <span style="color: rgb(0, 0, 0); font-weight: bold;">(Pending)</span>
                    @elseif($submission->status === 'approved')
                            <span style="color: rgb(0, 255, 64); font-weight: bold;">(Approved)</span>
                    @elseif($submission->status === 'rejected')
                            <span style="color: rgb(255, 0, 0); font-weight: bold;">(Rejected)</span>
                    @elseif($submission->status === 'revision')
                            <span style="color: blue; font-weight: bold;">(For Revision)</span>
                    @else
                            <span>(Unknown)</span>
                    @endif
                    <span style="text-align: center;">
                        {{ $submission->is_read ? 'Read' : 'Not read' }}
                    </span>
                </div>
        </div>
    @empty
        <p style="color: gray; text-align: center; margin-top: 20px;">
            No submitted documents yet.
        </p>
    @endforelse
</div>
@endsection

{{-- <script src="{{ asset('') }}"></script> --}}
