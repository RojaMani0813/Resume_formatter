<!DOCTYPE html>
<html>
<head>
    <title>Template</title>

    <style type="text/css">
        td {padding: 10px}
    </style>
</head>
<body>
    <table width="100%">
        <thead>
            <tr>
                <th> <h1>Resume Creator</h1></th>
            </tr>
            <tr>
                <th> 
                    <form method="POST" action="resume.php" enctype="multipart/form-data">
                        <h3>Choose your template</h3>
                        <select class="form-control" name="template" style="width: 200px;font-size: 20px;">
                            <option selected="" disabled=""> Select Template</option>
                            <option value="template2.php">Template1</option>
                            <option value="template1.php">Template2</option>
                        </select>
                        <br />
                        <br />
                        <h3>Upload Your resume here</h3>
                        <input type="file" name="docx" id="docx" style="width: 200px;font-size: 20px;">
                        <br /><br />
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </th>
            </tr>
        </thead>
    </table>
    
</body>
</html>