
    <table style="width: 100%;border: 3px solid #dddddd;border-radius: 10px;padding: 20px 0 20px 0;width: 100%;">
        <tbody>
            <tr style="text-align: center;">
                <td>
                <?php 
                     $active_theme = \App\Models\Theme::where('name',$details1['theme'])->first();
                 //    if($details1['theme'] == 'default'){
                 //        $image = 'dragonnn.gif';
                 //    }else{
                 //        $image = 'logo.jpg';
                 //    }
                ?>
                <img style="max-width: 20%;" src="<?php echo URL::to('/images/'.$details1['theme'].'/'.$active_theme->logo) ?>" alt="Game"> 
                </td>
            </tr>
            <tr>
            <td style="color: black;font-size: 15px;padding: 0 50px 0 50px;text-align:center;">
                    <?php echo  $details['text'] ?>
                    <hr>
                    [<?php echo Carbon\Carbon::now().'   ('.config('app.timezone').')'  ?>]
                    <br>
                    Sincerely,
                    <b><?php echo ($details['theme'] == 'default')?'Noor':ucfirst($details['theme']) ?> Games.<b>
                </td>
            </tr>
        </tbody>
    </table>