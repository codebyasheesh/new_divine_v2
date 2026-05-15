<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SoapNoteController extends Controller
{
    /**
     * This page shows the Generated PDF's
     */
    public function index()
    {
        $folderPath = public_path('admin_assets/assets/document');
        $files = File::files($folderPath);
        
        $pdfs = collect($files)->map(function ($file) {
            return [
                'name' => $file->getFilename(),
                'url' => asset('admin_assets/assets/document/'. $file->getFilename())
            ];
        });
        return view('admin.soapnote.index', compact('pdfs'));
    }

    public function generateSoapNote($id)
    {
        $detail = Booking::where('id', $id)->first();
        return view('admin.soapnote.generate_soapnote', compact('detail'));
    }

    public function generateSoapNotePDF(Request $request)
    {
        // Validate input
        $request->validate([
            'customer_name'     => 'required|string|max:255',
            'appointment_date'  => 'required|date',
            'time'              => 'required',
            'fee'               => 'nullable|string',
            'duration'          => 'nullable|string',
        ]);

        $techniques = $request->techniques;
        $grade = $request->grade;
        $fac_str = $request->fac_str;
        $hydro_type = $request->hydro_type;
        $other_type = $request->other_type;

        $techni = '';
        if(!empty($techniques)) {
            foreach($techniques as $val) {
                if($val == 'JOINT MOBILIZATION:' && (isset($grade) && !empty($grade)))
                {
                    $techni .= $val.' '.$grade.'<br>';
                }
                elseif($val == 'FACILITATED STRETCH:' && (isset($fac_str) && !empty($fac_str)))
                {
                    $techni .= $val.' '.$fac_str.'<br>';
                }
                elseif($val == 'HYDROTHERAPY' && (isset($hydro_type) && !empty($hydro_type)))
                {
                    $techni .= $val.': '.$hydro_type.'<br>';
                }
                elseif($val == 'OTHER' && (isset($other_type) && !empty($other_type)))
                {
                    $techni .= $val.': '.$other_type.'<br>';
                }
                else
                {
                    $techni .= $val.'<br>';
                }
            }
        }
        else
        {
            $techni .= 'Not Used';
        }
        $treatment = $request->treatment_notes;
        $treat = '';
        if(!empty($treatment))
        {
            $i = 1;
            foreach($treatment as $tval)
            {
                if($tval == 1)
                {
                    $treat .= $request->treat_note_9;
                }
                else
                {
                    $treat .= $tval.'<br>';
                }
                
                $i++;
            }
        }
        else
        {
            $treat = 'Not Available';
        }
        $area_treated = $request->area_treated;
        if(!empty($area_treated))
        {
            $area_treat = '';
            foreach($area_treated as $val)
            {
                $area_treat .= $val.'<br>';
            }
        }
        else
        {
            $area_treat = '';
        }
        $area_treated_other = $request->area_treated_other;
        if(!empty($area_treated_other))
        {
            if(!empty($area_treat))
            {
                $area_treat .= $area_treated_other;
            }
            else
            {
                $area_treat = $area_treated_other;
            }
        }
        $client_reac = $request->client_reaction;
        $client_rea = '';
        if(!empty($client_reac))
        {
            $i = 1;	
            foreach ($client_reac as $cl_val) 
            {
                if($cl_val == 1)
                {
                    $client_rea .= $request->clt_reaction_4;
                }
                else
                {
                    $client_rea .= $cl_val.'<br>';
                }
                
                $i++;
            }
        }
        if(empty($client_reac))
        {
            $client_rea = 'Not Available';
        }
        $home_exercises = $request->home_exercises;
        $hom_exer = '';
        if(!empty($home_exercises))
        {
            $i = 1;	
            foreach ($home_exercises as $hom_val) 
            {
                if($hom_val == 1)
                {
                    $hom_exer .= $request->hom_exercises_5;
                }
                else
                {
                    $hom_exer .= $hom_val.'<br>';
                }
                $i++;
            }
        }
        if(empty($home_exercises))
        {
            $hom_exer = 'Not Available';
        }

        $html = '
            <style>
                body { font-family: sans-serif; font-size: 14px; }
                table, td { border-collapse: collapse; }
                .table { width: 100%; border: 1px solid #bfbfbf; }
                .table td { padding: 10px; vertical-align: top; }
            </style>
            <table>
                <tr>
                    <td style="font-size: 15px;"><strong>Client Name: </strong>' . $request->customer_name . '</td>
                    <td>&nbsp;</td>
                    <td style="font-size: 15px;"><strong>Date:</strong> ' . $request->appointment_date . '</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <td style="font-size: 15px;"><strong>Time:</strong> ' . $request->time . '</td>
                    <td style="font-size: 15px;"><strong>Fee:</strong> $' . $request->fee . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-size: 15px;"><strong>Duration:</strong> ' . $request->duration . '</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
            </table>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td style="width:150px; border-right:1px solid #bfbfbf;">
                            <strong>TECHNIQUES USED:</strong><br><br>' . nl2br($techni) . '
                        </td>
                        <td style="width:350px; border-right:1px solid #bfbfbf;">
                            <strong>TREATMENT NOTES:</strong><br>' . nl2br($treat) . '<br>
                            <div style="border-bottom:1px solid #bfbfbf;">&nbsp;</div><br>
                            <strong>CLIENT REACTION/FEEDBACK TO TX:</strong><br>' . nl2br($client_rea) . '<br>
                            <div style="border-top:1px solid #bfbfbf;"></div>
                            <strong>HOME EXERCISES & SELF CARE TX RECOMMENDED:</strong><br>' . nl2br($hom_exer) . '
                        </td>
                        <td style="width:140px;">
                            <strong>AREAS TREATED:</strong><br><br>' . nl2br($area_treat) . '
                        </td>
                    </tr>
                </table>
            </div>';

        // File name
        $safeName = preg_replace('/[^a-z0-9]/i', '_', strtolower($request->customer_name));
        $safeTime = str_replace([':', ' '], ['-', ''], $request->time);
        $fileName = $safeName . '_' . $request->appointment_date . '_' . $safeTime . '.pdf';

        User::where('id', $request->customer_id)->update(['soap_note_link' => $fileName]);
        // Save path
        $savePath = public_path('admin_assets/assets/document/' . $fileName);

        // Ensure the directory exists
        File::ensureDirectoryExists(public_path('admin_assets/assets/document'));

        // Generate and save the PDF
        Pdf::loadHTML($html)->save($savePath);

        return redirect()->route('admin.soap_notes')->with('success', 'PDF generated and saved successfully.');
        // Optional: return path or success response
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'PDF generated and saved successfully.',
        //     'file_path' => asset('admin_assets/assets/document/' . $fileName)
        // ]);
    }

    public function download($filename)
    {
        $path = public_path('admin_assets/assets/document/' . $filename);
        if(File::exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'File not Found');
    }

    public function delete($filename) {
        // echo $filename; die(' test');
        $path = public_path('admin_assets/assets/document/' . $filename);

        if(File::exists($path)) {
            $detail = User::where('soap_note_link', $filename)->first();
            $update_record = User::where('id', $detail->id)->update(['soap_note_link' => '']);
            File::delete($path);
            return response()->json(['status'=>true, 'message' => 'File deleted Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'File not Found']);
    }
}
