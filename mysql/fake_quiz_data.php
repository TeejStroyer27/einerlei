<?php
for($k = 1718; $k <= 1874; $k++)
{
  if($k % 2)
  {
    $answer = 50;
  }
  else
  {
    $answer = 75;
  }
  printf("insert into LikertAnswer(license_id, question_id, answer) values(%d, %d, %d);\n", 11844, $k, $answer);
}
