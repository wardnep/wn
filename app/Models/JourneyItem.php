<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class JourneyItem extends Model
{
    use SoftDeletes;

    public function journey()
    {
        return $this->belongsTo('App\Models\Journey');
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
            $color = '#2E5E3A';
        } else if ($this->position == 'SELL') {
            $color = '#FF0000';
        }

        return "<font color=\"$color\">$this->position</font>";
    }

    public function getDresultAttribute()
    {
        $color = '';
        if ($this->result == 'WIN') {
            $color = '#2E5E3A';
        } else if ($this->result == 'LOSS') {
            $color = '#FF0000';
        } else if ($this->result == 'BE') {
            $color = '#0000FF';
        } else if ($this->result == 'CLOSE') {
            $color = '#0000FF';
        }

        return "<font color=\"$color\">$this->result</font>";
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
            return 'https://athikit.co.th/'.$this->image;
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
            $color = '#1B5E20';
        } else if ($this->grade == 'A') {
            $color = '#2E7D32';
        } else if ($this->grade == 'B') {
            $color = '#F9A825';
        } else if ($this->grade == 'C') {
            $color = '#FB8C00';
        } else if ($this->grade == 'D') {
            $color = '#E53935';
        } else if ($this->grade == 'F') {
            $color = '#B71C1C';
        } else {
            return "";
        }

        return "<font color=\"$color\">".$this->grade."</font>";
    }
}
