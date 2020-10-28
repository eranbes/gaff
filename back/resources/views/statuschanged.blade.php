<div>

    <h2>Changed entries</h2>

    <h3>
        <?php if ($report[1]) echo 'Added entries:'; ?>
    </h3>

    <?php foreach ($report[1] as $e) { ?>

    <ul>
        <li>
            Publisher name : <strong>
                {{ $e['publisher_name'] }}
            </strong>
        </li>
        <li>
            Entries added for {{ $e['is_app'] ? 'app-ads.txt' : 'ads.txt' }} :<br/>
            {{ $e['entry_name'] }}
        </li>
        <li>
            Bundle ids associated with the entries added :<br/>
            <?php foreach ($e['bundle_ids'] as $b_id) {?>

            {{ $b_id }}<br/>

            <?php } ?>
        </li>

    </ul>

    <?php } ?>

    <h3>
        <?php if ($report[2]) echo 'Entries Deleted:'; ?>
    </h3>

    <?php foreach ($report[2] as $e) { ?>

    <ul>
        <li>
            Publisher name : <strong>
                {{ $e['publisher_name'] }}
            </strong>
        </li>
        <li>
            Entries deleted from {{ $e['is_app'] ? 'app-ads.txt' : 'ads.txt' }} :<br/>
            {{ $e['entry_name'] }}
        </li>
        <li>
            Bundle ids associated with the entries deleted :<br/>
            <?php foreach ($e['bundle_ids'] as $b_id) {?>

            {{ $b_id }}<br/>

            <?php } ?>
        </li>

    </ul>

    <?php } ?>

    <h3>
        <?php if ($report[0]) echo 'Entries Unavailable:'; ?>
    </h3>

    <?php foreach ($report[0] as $e) { ?>

    <ul>
        <li>
            Publisher name : <strong>
                {{ $e['publisher_name'] }}
            </strong>
        </li>
        <li>
            Entries Unavailable from {{ $e['is_app'] ? 'app-ads.txt' : 'ads.txt' }} :<br/>
            {{ $e['entry_name'] }}
        </li>
        <li>
            Bundle ids associated with the entries unavailable :<br/>

            <?php if($e['bundle_ids']) {

                foreach ($e['bundle_ids'] as $b_id) {?>

            {{ $b_id }}<br/>

            <?php }

                } else { ?>

            empty

            <?php } ?>

        </li>

    </ul>

    <?php } ?>

</div>
