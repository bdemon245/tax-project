<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Enums\PageName;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Achievement;
use App\Models\Appointment;
use App\Models\Banner;
use App\Models\ClientStudio;
use App\Models\CustomService;
use App\Models\ExpertProfile;
use App\Models\Info;
use App\Models\Map;
use App\Models\PartnerSection;
use App\Models\Purchase;
use App\Models\ServiceSubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function trainingPage()
    {
        return view('frontend.pages.training');
    }
    public function industriesPage()
    {
        $subCategories  = ServiceSubCategory::with('serviceCategory')->where('service_category_id', 3)->get();
        $achievements   = Achievement::latest()->get();
        $partners       = PartnerSection::latest()->limit(10)->get();
        $customServices = CustomService::with('image')->where('page_name', PageName::Account)->get();
        $infos1 = Info::where(['section_id' => 1, 'page_name' => 'account'])->latest()->take(4)->get();
        $infos2 = Info::where(['section_id' => 2, 'page_name' => 'account'])->latest()->take(4)->get();
        return view('frontend.pages.industries.industries', compact('subCategories', 'achievements', 'partners', 'customServices', 'infos1', 'infos2'));
    }
    public function clientStudioPage()
    {
        $data                = ClientStudio::get();
        $description         = $data[ 0 ]->description;
        $appointmentSections = Appointment::latest()->limit(5)->get();
        $banners             = Banner::latest()->limit(10)->get();
        $partners            = PartnerSection::latest()->limit(10)->get();
        return view('frontend.pages.clientStudio.clientStudio', compact('data', 'description', 'appointmentSections', 'banners', 'partners'));
    }
    public function appointmentPage(Request $request, ?ExpertProfile $expertProfile = null)
    {
        $office = !empty($request->query('office_id')) ? Map::find($request->query('office_id')) : null;
        if ($office == null) {
            $maps = Map::where(function (Builder $q) use ($request) {
                if ($request->query('branch-thana')) {
                    $q->where('thana', $request->query('branch-thana'));
                }
                if ($request->query('branch-district')) {
                    $q->where('district', $request->query('branch-district'));
                }
            })->get();
        } else {
            $maps = [ $office ];
        }
        $branchDistricts = Map::select([ 'district', 'thana' ])->distinct()->get()->pluck('district');
        $branchThanas    = Map::select([ 'district', 'thana' ])->distinct()->where(function (Builder $q) use ($request) {
            if (!empty($request->query('branch-district'))) {
                $q->where('district', $request->query('branch-district'));
            }
        })->get()->pluck('thana');
        $banners      = getRecords('banners');
        $infos1       = Info::where('section_id', 1)->get();
        $testimonials = \App\Models\Review::with('user')->latest()->limit(10)->get();
        return view('frontend.pages.appointment.makeAppointment', compact('banners', 'expertProfile', 'infos1', 'testimonials', 'maps', 'branchDistricts', 'branchThanas', 'office'));
    }
    public function appointmentVirtual(Request $request, ?ExpertProfile $expertProfile = null)
    {
        $office = !empty($request->query('office_id')) ? Map::find($request->query('office_id')) : null;
        $banners      = getRecords('banners');
        $infos1       = Info::where('section_id', 1)->get();
        $testimonials = \App\Models\Review::with('user')->latest()->limit(10)->get();
        return view('frontend.pages.appointment.makeAppointmentVirtual', compact('banners', 'expertProfile', 'testimonials', 'infos1', 'office'));
    }
    public function aboutPage()
    {
        $about = About::first();
        return view('frontend.pages.about', compact('about'));
    }
    public function officePage(Request $request)
    {
        $maps = Map::where(function (Builder $q) use ($request) {
            if ($request->query('thana')) {
                $q->where('thana', $request->query('thana'));
            }
            if ($request->query('district')) {
                $q->where('district', $request->query('district'));
            }
        })->get();
        $districts = Map::select([ 'district', 'thana' ])->distinct()->get()->pluck('district');
        $thanas    = Map::select([ 'district', 'thana' ])->distinct()->where(function (Builder $q) use ($request) {
            if (!empty($request->query('district'))) {
                $q->where('district', $request->query('district'));
            }
        })->get()->pluck('thana');
        return view('frontend.pages.office', compact('maps', 'districts', 'thanas'));
    }
    public function contactPage()
    {
        $maps                = Map::get();
        $appointmentSections = Appointment::latest()->limit(5)->get();
        $partners            = PartnerSection::latest()->limit(10)->get();
        return view('frontend.pages.contact', compact('maps', 'appointmentSections', 'partners'));
    }
    public function becomePartnerPage()
    {
        $user = auth()->user();
        return view('frontend.pages.becomePartner', compact('user'));
    }

    //promo codes view page
    public function PromoCodePage()
    {
        $user_id    = Auth::user()->id;
        $promoCodes = User::find($user_id)->promoCodes()->where('status', 1)->get();
        return view('frontend.pages.promoCodesPage', compact('promoCodes'));
    }

    //notification client side view page
    public function notificationPage()
    {
        return view('frontend.pages.notificationPage');
    }

    //show all my courses in frontend
    public function myCourses()
    {
        $user    = User::where('id', auth()->id())->first();
        $courses = $user->purchased('course');
        return view('frontend.pages.myCourses', compact('courses'));
    }
    //show all my payments/payment history in frontend
    public function myPayments()
    {
        $payments = User::find(auth()->id())->purchases()->get();
        // dd($payments);
        return view('frontend.pages.myPayments', compact('payments'));
    }
    //Contact Developers page:
    public function contactDevelopers()
    {
        return view('frontend.pages.contact-developers');
    }

    //shwo payment history
    public function myPaymentShow($id)
    {
        $history = Purchase::find($id)->where('user_id', auth()->id())->first();
        return view('frontend.pages.myPaymentShow', compact('history'));
    }
}
