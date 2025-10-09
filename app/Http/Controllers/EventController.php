<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Order;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\AppUser;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(Auth::user()->hasRole('admin')){
            $events = Event::with(['category','organization'])->where('is_deleted',0)->orderBy('id','DESC')->get();
        }
        elseif(Auth::user()->hasRole('organization')){
            $events = Event::with(['category','organization'])->where([['user_id',Auth::user()->id],['is_deleted',0]])->orderBy('id','DESC')->get();
            foreach ($events as $value) {
                $value->scanner = User::find($value->scanner_id);
            }
        }

        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status',1)->orderBy('id','DESC')->get();
        $users = User::role('organization')->orderBy('id','DESC')->get();
        if(Auth::user()->hasRole('admin')){
            $scanner = User::role('scanner')->orderBy('id','DESC')->get();
        }
        else if(Auth::user()->hasRole('organization')){
            $scanner = User::role('scanner')->where('org_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        return view('admin.event.create', compact('category','users','scanner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'image' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required',
            'people' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image'))
        {

            $data['image'] = (new AppHelper)->saveImage($request);
        }
        if(!Auth::user()->hasRole('admin')){
            $data['user_id'] = Auth::user()->id;
        }
        $event = Event::create($data);
        return redirect()->route('events.index')->withStatus(__('Event is added successfully.'));
    }

    public function show(Event $event)
    {
        $event = Event::with(['category','organization'])->find($event->id);
        $event->ticket = Ticket::where([['event_id',$event->id],['is_deleted',0]])->orderBy('id','DESC')->get();
        $event->sales = Order::with(['customer:id,name','ticket:id,name'])->where('event_id',$event->id)->orderBy('id','DESC')->get();
        foreach ($event->ticket as $value) {
            $value->used_ticket = Order::where('ticket_id',$value->id)->sum('quantity');
        }
        return view('admin.event.view', compact( 'event'));
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category =  Category::where('status',1)->orderBy('id','DESC')->get();
        $users = User::role('organization')->orderBy('id','DESC')->get();
        if(Auth::user()->hasRole('admin')){
            $scanner = User::role('scanner')->orderBy('id','DESC')->get();
        }
        else if(Auth::user()->hasRole('organization')){
            $scanner = User::role('scanner')->where('org_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        return view('admin.event.edit', compact( 'event','category','users','scanner'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required',
            'people' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image'))
        {
            (new AppHelper)->deleteFile($event->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $event = Event::find($event->id)->update($data);
        return redirect()->route('events.index')->withStatus(__('Event is updated successfully.'));
    }

    public function destroy(Event $event)
    {
        try{
            Event::find($event->id)->update(['is_deleted'=>1,'event_status'=>'Deleted']);
            $ticket = Ticket::where('event_id',$event->id)->update(['is_deleted'=>1]);
            return true;
        }catch(Throwable $th){
            return response('Data is Connected with other Data', 400);
        }
    }

    public function getMonthEvent(Request $request){
        $day = Carbon::parse($request->year.'-'.$request->month.'-01')->daysInMonth;
        if(Auth::user()->hasRole('organization')){
            $data = Event::whereBetween('start_time', [ $request->year."-".$request->month."-01 12:00",  $request->year."-".$request->month."-".$day."  23:59"])
            ->where([['status',1],['is_deleted',0],['user_id',Auth::user()->id]])
            ->orderBy('id','DESC')
            ->get();
        }
        if(Auth::user()->hasRole('admin'))
        {
            $data = Event::whereBetween('start_time', [ $request->year."-".$request->month."-01 12:00",  $request->year."-".$request->month."-".$day." 23:59"])
            ->where([['status',1],['is_deleted',0]])->orderBy('id','DESC')->get();
        }
        foreach ($data as $value) {
            $value->tickets = Ticket::where([['event_id',$value->id],['is_deleted',0]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id',$value->id)->sum('quantity');
            $value->day = $value->start_time->format('D');
            $value->date = $value->start_time->format('d');
            $value->average = $value->tickets==0? 0: $value->sold_ticket*100/$value->tickets;
        }
        return response()->json([ 'data' => $data,'success'=>true], 200);
    }

    public function eventGallery($id){
        $data  = Event::find($id);
        return view('admin.event.gallery',compact( 'data'));
    }

    public function addEventGallery(Request $request){
        $event = array_filter(explode(',',Event::find($request->id)->gallery));
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            array_push($event,$name);
            Event::find($request->id)->update(['gallery'=>implode(',',$event)]);
        }
        return true;
    }

    public function removeEventImage($image,$id){

        $gallery = array_filter(explode(',',Event::find($id)->gallery));
        if(count(array_keys($gallery,$image))>0){
            if (($key = array_search($image, $gallery)) !== false) {
                unset($gallery[$key]);
            }
        }
        $aa =implode(',',$gallery);
        $data= Event::find($id);
        $data->gallery =$aa;
        $data->update();
        return redirect()->back();
    }
}
