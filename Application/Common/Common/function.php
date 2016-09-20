<?php
/**
 * 建立下拉框.
 */
function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectedValue = '')
{
    $model = D($tableName);
    $data = $model->field("$valueFieldName,$textFieldName")->select();
    $select = "<select name='$selectName'>";
    $select .= "<option value=''>请选择</option>";
    foreach ($data as $value) {
        if ($selectedValue != '' && $selectedValue == $value[$valueFieldName]) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $select .= "<option $selected value=$value[$valueFieldName]>$value[$textFieldName]</option>";
    }
    $select .= '</select>';
    echo $select;
}

/**
 * 前端显示图片使用.
 *
 * @param $url 图片显示的路径（数据库中的）
 * @param $width 可选 默认为空  显示图片的宽
 * @param $height 可选 默认为空 显示图片的高
 */
function showImage($url, $width = '', $height = '')
{
    $conf = C('IMAGE_CONFIG');
    if ($width) {
        $width = "width = '$width'";
    }
    if ($height) {
        $height = "height = '$height'";
    }

    echo "<img $width $height src='{$conf['viewPath']}/$url'>";
}

/**
 * 删除一个数组中的所有图片.
 *
 * @param $image 图片数组
 */
function deleteImage($image = array())
{
    $savePath = C('IMAGE_CONFIG')['rootPath'];
    foreach ($image as $value) {
        // var_dump($savePath.$value);
    unlink($savePath.$value);
    }
}
