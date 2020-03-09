@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

// $absences = $doctor->absences->map(function($absence){
//     $start = Carbon\Carbon::createFromFormat('Y-m-d', $absence->day->start_at);
//     $duration = $absence->day->duration;
//     $end = $start->copy()->addWeekdays($duration-1);
//     $absence_type = $absence->type;

//     for ($i=0; $i < $duration; $i++) {
//         $date = $start->copy()->addWeekdays($i)->format('Y-m-d');

//         if(App::make('holidays')->isHoliday($date))
//         {
//             $end->addWeekday();
//         }
//     }

//     $absence = Carbon\CarbonPeriod::create($start->copy(), $end);

//     $filtered = collect($absence)->filter(function($date) {
//         return ! $date->isWeekend() && ! App::make('holidays')->isHoliday($date->format('Y-m-d'));
//     })->map(function($date){
//         return $date->format('Y-m-d');
//     })->flatten();

//     return $new = collect([
//         'dates' => $filtered,
//         'type' => $absence_type
//     ]);
// });
