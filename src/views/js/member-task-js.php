<script>
  //　進捗度バーを着色
  <?php for($k = 0; $k < $j; $k++) :?>
        let progressBar<?php echo $k;?> = document.getElementById(<?php echo $k;?>);
        let percent<?php echo $k;?> = <?php echo $progresses[$k]; ?>;

        progressBar<?php echo $k;?>.classList.remove('progress-30', 'progress-60', 'progress-80', 'progress-100');
        if (percent<?php echo $k;?> === 30) {
            progressBar<?php echo $k;?>.classList.add('progress-30');
        } else if (percent<?php echo $k;?> === 60) {
            progressBar<?php echo $k;?>.classList.add('progress-60');
        } else if (percent<?php echo $k;?> === 80) {
            progressBar<?php echo $k;?>.classList.add('progress-80');
        } else {
            progressBar<?php echo $k;?>.classList.add('progress-100');
        }
    <?php endfor;?>

    function calcProjectProgress(dataList) {
  const parentTaskProgress = [];

  Object.keys(dataList).forEach((key) => {
    const parent_tasks = dataList[key].parent_tasks;
    const progress =
      parent_tasks.reduce((acc, cur) => {
        return acc + cur.progress;
      }, 0) / parent_tasks.length;

    parentTaskProgress.push(progress);
  });

  const projectTaskProgress =
    parentTaskProgress.reduce((acc, progress) => {
      return acc + progress;
    }, 0) / parentTaskProgress.length;

    return projectTaskProgress
}

const projectTaskProgress = calcProjectProgress(
        <?php echo
    json_encode($weekly_tasks)
    ?>)

    const $projectProgress = document.getElementById('project-progress');
    $projectProgress.textContent = projectTaskProgress.toFixed(2) + '%';

</script>

