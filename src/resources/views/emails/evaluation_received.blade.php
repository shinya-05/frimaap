<p>{{ $evaluation->evaluatedUser->name }}さん、こんにちは、取引が完了しました。</p>

<p>{{ $evaluation->evaluator->name }}さんから新しい評価が届きました。</p>

<p>評価スコア：{{ $evaluation->score }} / 5</p>

@if($evaluation->comment)
<p>コメント：{{ $evaluation->comment }}</p>
@endif

<p>マイページで確認してください。</p>
