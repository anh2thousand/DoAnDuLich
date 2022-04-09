<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookTour;
use App\Models\Tour;

class BookTourController extends Controller
{
    public function __construct(BookTour $bookTour)
    {
        view()->share([
            'book_tour_active' => 'active',
            'status' => $bookTour::STATUS,
            'classStatus' => $bookTour::CLASS_STATUS,
        ]);
        $this->bookTour = $bookTour;
    }
    //
    public function index(Request $request)
    {
        $bookTours = BookTour::with(['tour', 'user']);

        if ($request->name_tour) {
            $nameTour = $request->name_tour;
            $bookTours->whereIn('b_tour_id', function ($q) use ($nameTour) {
                $q->from('tours')
                    ->select('id')
                    ->where('t_title', 'like', '%'.$nameTour.'%');
            });
        }
        if ($request->b_name) {
            $bookTours->where('b_name', 'like', '%'.$request->b_name.'%');
        }
        if ($request->b_email) {
            $bookTours->where('b_email', $request->b_email);
        }

        if ($request->b_phone) {
            $bookTours->where('b_phone', $request->b_phone);
        }

        $bookTours = $bookTours->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
        return view('admin.book_tour.index', compact('bookTours'));
    }

    public function delete($id)
    {
        $bookTour = BookTour::find($id);
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $bookTour->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

    public function updateStatus(Request $request, $status, $id)
    {
        $bookTour = BookTour::find($id);
        $numberUser = $bookTour->b_number_adults + $bookTour->b_number_children;
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        \DB::beginTransaction();
        try {
            $bookTour->b_status = $status;
            if ($bookTour->save()) {
                if ($status == 5 && $bookTour->b_status != 5) {
                    $tour = Tour::find($bookTour->b_tour_id);
                    $numberRegistered = $tour->t_number_registered - $numberUser;
                    $tour->t_number_registered = $numberRegistered > 0 ? $numberRegistered : 0;
                    $tour->save();
                }
            }
            \DB::commit();
            return redirect()->route('book.tour.index')->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
}
