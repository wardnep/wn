<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JourneyItem extends Model
{
    use SoftDeletes;

    public function journey()
    {
        return $this->belongsTo('App\Models\Journey');
    }

    public function getDdateAttribute()
    {
        $date = $this->date;

        // hash วันที่ -> hue (0-359) ได้ผลคงที่ทุกครั้ง
        $hue = hexdec(substr(md5((string) $date), 0, 8)) % 360;

        // พื้นหลังเข้ม จึงใช้ lightness สูงเพื่อให้อ่านง่าย
        $color = "hsl({$hue}, 70%, 65%)";

        return '<span style="color: ' . $color . '; font-weight: 600;">'
            . e($date)
            . '</span>';
    }

    public function getDEntrySessionAttribute()
    {
        $color = '#CCCCCC';
        if ($this->entry_session == 'Asia') {
            $color = '#8B3A1A';
        } else if ($this->entry_session == 'London') {
            $color = '#1E4FA3';
        } else if ($this->entry_session == 'London + NY') {
            $color = '#7A1E4A';
        } else if ($this->entry_session == 'NY') {
            $color = '#8A7A1E';
        }

        return "<font color=\"$color\">$this->entry_session</font>";
    }

    public function getDExitSessionAttribute()
    {
        $color = '#CCCCCC';
        if ($this->exit_session == 'Asia') {
            $color = '#8B3A1A';
        } else if ($this->exit_session == 'London') {
            $color = '#1E4FA3';
        } else if ($this->exit_session == 'London + NY') {
            $color = '#7A1E4A';
        } else if ($this->exit_session == 'NY') {
            $color = '#8A7A1E';
        }

        return "<font color=\"$color\">$this->exit_session</font>";
    }

    public function getDpositionAttribute()
    {
        if ($this->position == 'BUY') {
            $color = '#4ade80';
        } else if ($this->position == 'SELL') {
            $color = '#ff6b6b';
        }

        return "<font color=\"$color\">$this->position</font>";
    }

    public function getDresultAttribute()
    {
        $colors = [
            'WIN'   => '#4ADE80',   // เขียวสว่าง
            'LOSS'  => '#ff6b6b',   // แดงสว่าง ไม่แสบตา
            'BE'    => '#60A5FA',   // ฟ้าสว่าง
            'CLOSE' => '#60A5FA',   // ฟ้าสว่าง
        ];

        return "<font color=\"$color\">$this->result</font>";
    }

    public function getDresultR1Attribute()
    {
        $colors = [
            'WIN'   => '#4ADE80',   // เขียวสว่าง
            'LOSS'  => '#ff6b6b',   // แดงสว่าง ไม่แสบตา
            'BE'    => '#60A5FA',   // ฟ้าสว่าง
            'CLOSE' => '#60A5FA',   // ฟ้าสว่าง
        ];

        $color = $colors[$this->result_r1] ?? '';

        return "<font color=\"$color\">$this->result_r1</font>";
    }

    public function getDresultR2Attribute()
    {
        $colors = [
            'WIN'   => '#4ADE80',   // เขียวสว่าง
            'LOSS'  => '#ff6b6b',   // แดงสว่าง ไม่แสบตา
            'BE'    => '#60A5FA',   // ฟ้าสว่าง
            'CLOSE' => '#60A5FA',   // ฟ้าสว่าง
        ];

        $color = $colors[$this->result_r2] ?? '';

        return "<font color=\"$color\">$this->result_r2</font>";
    }

    public function getDsl1Attribute()
    {
        if ($this->result == 'LOSS') {
            return "<font color=\"#FF0000\">".number_format((float) $this->tp1)."</font>";
        } else {
            // return '0';
        }
    }

    public function getDsl2Attribute()
    {
        if ($this->result == 'LOSS') {
            return "<font color=\"#FF0000\">".number_format((float) $this->tp1 * 2)."</font>";
        } else {
            // return '0';
        }
    }

    public function getDtp1Attribute()
    {
        if ($this->result == 'WIN') {
            return "<font color=\"#0000FF\">".number_format((float) $this->tp1)."</font>";
        } else if ($this->result == 'LOSS') {
            return "<font color=\"#FF0000\">".number_format((float) $this->tp1)."</font>";
        }
    }

    public function getDtp2Attribute()
    {
        if ($this->tp2 > 0) {
            return "<font color=\"#0000FF\">".number_format((float) $this->tp2)."</font>";
        } else {
            // return '0';
        }
    }

    public function getDRAttribute()
    {
        if ((float) $this->result_r1 > 0) {
            return "<font color=\"#0000FF\">".(float) $this->result_r1."</font>";
        } else if ((float) $this->result_r1 < 0) {
            return "<font color=\"#FF0000\">".(float) $this->result_r1."</font>";
        } else {
            return "<font color=\"\">".(float) $this->result_r1."</font>";
        }
    }

    public function getDimageAttribute()
    {
        if ($this->image) {
            if (Str::startsWith($this->image, 'http')) {
                return $this->image;
            } else {
                return 'https://athikit.co.th/'.$this->image;
            }
        }

        return '';
    }

    public function getDimage2Attribute()
    {
        if ($this->image2) {
            return 'https://athikit.co.th/'.$this->image2;
        }

        return '';
    }

    public function getDgradeAttribute()
    {
        if ($this->grade == 'A+') {
            $color = '#00E676';   // เขียวสว่างสุด
        } else if ($this->grade == 'A') {
            $color = '#4ADE80';
        } else if ($this->grade == 'B') {
            $color = '#FACC15';
        } else if ($this->grade == 'C') {
            $color = '#FB923C';
        } else if ($this->grade == 'D') {
            $color = '#FB7185';
        } else if ($this->grade == 'F') {
            $color = '#ff6b6b';
        } else {
            return "";
        }

        return "<font color=\"$color\">".$this->grade."</font>";
    }
}
