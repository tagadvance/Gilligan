<?php

namespace tagadvance\gilligan\text;

class HumanReadableByteCountMetricFormatter extends HumanReadableByteCountFormatter {

	const UNIT = 1000;

	const PREFIXES = 'kMGTPE';
	
	protected function prefix(int $index): string {
		$pre = self::PREFIXES;
		return $pre {$index};
	}

}