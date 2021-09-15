<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getFullnameFromParts($surname, $name, $patronymic)
{
    $full_name = $surname . ' ' . $name . ' ' . $patronymic;
    return $full_name;
}

function getPartsFromFullname($full_name)
{
    $arr_value = explode(' ', $full_name);
    $arr_key = [
        'surname', 
        'name', 
        'patronymic', 
    ];

    return array_combine($arr_key, $arr_value);
}

function getShortName($full_name)
{
    $arrName = getPartsFromFullname($full_name);
    $short_name = $arrName['name'] . ' ' . mb_substr($arrName['surname'], 0, 1) . '.';
    return $short_name;
}

function getGenderFromName($fullNameArray){
    $surname =$fullNameArray['surname'];
    $name = $fullNameArray['name'];
    $patronomyc = $fullNameArray['patronomyc'];
    $gender = 0;

    if(mb_substr($surname, -1) == 'в'){
        $gender = $gender + 1;
        
    }elseif(mb_substr($surname, -2) == 'ва'){
        $gender = $gender - 1;
    }

    if(mb_substr($name, -1) == 'й' || mb_substr($name, -1) == 'н'){
        $gender = $gender + 1;
        
    }elseif(mb_substr($name, -1) == 'а'){
        $gender = $gender - 1;
    }

    if(mb_substr($patronomyc, -2) == 'ич'){
        $gender = $gender + 1;

    }elseif(mb_substr($patronomyc, -3) == 'вна'){
        $gender = $gender - 1;
    }
    if($gender > 0 ){
        return 'мужской пол';
    }elseif($gender < 0){
        return 'женский пол';
    }else{
        return 'неопределенный пол';
    }

}
echo  getGenderFromName(getPartsFromFullname($fullName));
echo '<br>';

function getGenderDescription($arr)
{
    foreach ($arr as $item){
        $arrayNew[] = getGenderFromName($item['fullname']);
    }

    $arrWithMan = array_filter($arrayNew, function($gender){
        if ($gender == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    });

    $arrWithWoman = array_filter($arrayNew, function($gender){
        if ($gender == -1)
        {
            return true;
        }
        else
        {
            return false;
        }
    });

    $arrWithUndefined = array_filter($arrayNew, function($gender){
        if ($gender == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    });

    $result = 'Гендерный состав аудитории:<br>' . '---------------------------<br>';
    $manCount = round((count($arrWithMan) / count($arrayNew)) * 100, 2);
    $result .= "Мужчины - $manCount%<br>";
    $womanCount = round((count($arrWithWoman) / count($arrayNew)) * 100, 2);
    $result .= "Женщины - $womanCount%<br>";
    $undefinedCount = round((count($arrWithUndefined) / count($arrayNew)) * 100, 2);
    $result .= "Не удалось определить - $undefinedCount%<br>";

    echo $result;    
}

echo getGenderDescription($example_persons_array);
