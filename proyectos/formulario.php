<h3><?php echo get_string('tit-aproy','local_gim');?> </h3>
<hr>
<form method="post" enctype="multipart/form-data" >
    <table>
        <tr>
            <td>
                <?php echo get_string('nom-aproy','local_gim');?>: 
            </td>
            <td>
                <input type="text" name="proyname" required>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo get_string('des-aproy','local_gim');?>:  
            </td>
            <td>
                <textarea name="desc" required></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo get_string('img-aproy','local_gim');?>:  
            </td>
            <td>
                <input type="file" name="Archivos" id="Archivos">
            </td>
        </tr>
        <tr>
            <td>
                <?php echo get_string('vid-aproy','local_gim');?>:  
            </td>
            <td>
                 <input type="file" name="video" id="Archivos">
            </td>
        </tr>
        <tr>
            <td>
                <input type="Reset" value="<?php echo get_string('del-aproy','local_gim');?>" >
            </td>
            <td>
                <input type="submit" value="<?php echo get_string('sav-aproy','local_gim');?>">
            </td>
        </tr>
    </table>
</form>