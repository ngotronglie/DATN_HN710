<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getDistrics(Request $request)
    {
        $id = $request->province_id;
        $district = District::where('province_code', $id)->get();
        $response = [
            'html' => $this->renderDisHtml($district)
        ];
        return response()->json($response);
    }

    public function getWards(Request $request)
    {
        $id = $request->district_id;
        $ward = Ward::where('district_code', $id)->get();
        $response = [
            'html' => $this->renderWardHtml($ward)
        ];
        return response()->json($response);
    }

    public function getDistricts(Request $request)
    {
        $cityCode = $request->input('city_code');

        if (!$cityCode) {
            return response()->json([], 400);
        }

        $districts = District::where('province_code', $cityCode)->get(['code', 'full_name']);
        return response()->json($districts, 200);
    }

    public function getWardLoad(Request $request)
    {
        $districtsCode = $request->input('districtsCode');

        if (!$districtsCode) {
            return response()->json([], 400);
        }

        $districts = Ward::where('district_code', $districtsCode)->get(['code', 'full_name']);
        return response()->json($districts, 200);
    }


    public function renderDisHtml($value)
    {
        $html = '<option value="0">[Chọn Quận/Huyện]</option>';
        foreach ($value as $item) {
            $html .= '<option value="' . $item->code . '">' . $item->name . '</option>';
        }
        return $html;
    }

    public function renderWardHtml($value)
    {
        $html = '<option value="0">[Chọn Phường/Xã]</option>';
        foreach ($value as $item) {
            $html .= '<option value="' . $item->code . '">' . $item->name . '</option>';
        }
        return $html;
    }
}
