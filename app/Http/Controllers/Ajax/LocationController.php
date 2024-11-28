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

    public function renderDisHtml($value)
    {
        $html = '<option value="0">[Chọn Quận/Huyện]</option>';
        foreach ($value as $value) {
            $html .= '<option value="' . $value->code . '">' . $value->name . '</option>';
        }
        return $html;
    }

    public function renderWardHtml($value)
    {
        $html = '<option value="0">[Chọn Phường/Xã]</option>';
        foreach ($value as $value) {
            $html .= '<option value="' . $value->code . '">' . $value->name . '</option>';
        }
        return $html;
    }
}
