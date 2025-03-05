<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RhymeSchemeController extends Controller
{
    /**
     * แสดงฟอร์มสำหรับตรวจสอบโครงสร้างสัมผัส
     */
    public function showForm()
    {
        return view('rhyme');
    }

    /**
     * ประมวลผลฟอร์มและตรวจสอบความถูกต้องของโครงสร้างสัมผัส
     */
    public function processForm(Request $request)
    {
        // ตรวจสอบข้อมูลที่ป้อนเข้ามา
        $request->validate([
            'rhyme_scheme' => 'required|string'
        ], [
            'rhyme_scheme.required' => 'กรุณากรอกโครงสร้างสัมผัส',
            'rhyme_scheme.string' => 'โครงสร้างสัมผัสต้องเป็นตัวอักษรเท่านั้น',
        ]);

        // แปลงตัวอักษรให้เป็นตัวพิมพ์ใหญ่ทั้งหมด
        $rhymeScheme = strtoupper(trim($request->rhyme_scheme));
        $error = $this->validateRhymeScheme($rhymeScheme);

        // หากพบข้อผิดพลาด ให้ส่งกลับไปยังฟอร์มพร้อมแสดงข้อความแจ้งเตือน
        if ($error) {
            return back()->withErrors(['rhyme_scheme' => $error])->withInput();
        }

        // หากข้อมูลถูกต้อง ให้ส่งกลับไปยังฟอร์มพร้อมข้อความแจ้งเตือนว่า "รูปแบบสัมผัสถูกต้อง!"
        return back()->with('success', 'รูปแบบสัมผัสถูกต้อง!');
    }

    /**
     * ตรวจสอบโครงสร้างสัมผัสตามกฎที่กำหนด
     */
    private function validateRhymeScheme($input)
    {
        // แยกโครงสร้างสัมผัสออกเป็นกลุ่มโดยใช้ช่องว่างเป็นตัวแบ่ง
        $blocks = explode(' ', trim($input));

        foreach ($blocks as $block) {
            $length = strlen($block);

            // กฎข้อที่ 1: แต่ละกลุ่มต้องมี 2, 4 หรือ 6 บรรทัดเท่านั้น
            if (!in_array($length, [2, 4, 6])) {
                return "ข้อผิดพลาด: แต่ละกลุ่มสัมผัสต้องมี 2, 4 หรือ 6 บรรทัด";
            }

            // กฎข้อที่ 2: ตัวอักษรทุกตัวต้องมีคู่สัมผัสภายในกลุ่มเดียวกัน
            $charCount = array_count_values(str_split($block));

            foreach ($charCount as $char => $count) {
                if ($count != 2 && $count != 4) {
                    return "ข้อผิดพลาด: รูปแบบสัมผัส '$block' ไม่ถูกต้อง ตัวอักษรแต่ละตัวต้องมีคู่สัมผัสในกลุ่มเดียวกัน";
                }
            }
        }

        return null; // ไม่มีข้อผิดพลาด
    }
}
