<?php
namespace cjrasmussen\Number;

class Convert
{
	/**
	 * Converts an integer to an ordinal number
	 *
	 * @param int $int
	 * @return string
	 */
	public static function intToOrdinal($int): string
	{
		$num = trim($int);

		if ((substr($num, -2) >= 11) AND (substr($num, -2) <= 13) AND (strlen($num) === 2)) {
			$ordinal = 'th';
		} else {
			$last_char = $num{(strlen($num) - 1)};

			switch ($last_char) {
				case '1':
					$ordinal = 'st';
					break;
				case '2':
					$ordinal = 'nd';
					break;
				case '3':
					$ordinal = 'rd';
					break;
				default:
					$ordinal = 'th';
					break;
			}
		}

		return $num . $ordinal;
	}


	/**
	 * Returns the english-language version of a number
	 *
	 * $force_hundreds as true returns numbers such as 3916 as thirty-nine hundred sixteen rather than three thousand nine hundred sixteen
	 *
	 * @param int $int
	 * @param bool $force_hundreds
	 * @return string
	 */
	public static function intToEnglish($int, $force_hundreds = false): string
	{
		$num = trim($int);

		$num = str_replace([',', ' '], '', $num);
		if (false !== strpos($num, '.')) {
			$num = substr($num, 0, strpos($num, '.'));
		}
		$labels = [
			'hundred',
			'thousand',
			'million',
			'billion',
			'trillion',
			'quadrillion',
			'quintillion',
			'sextillion',
			'septillion',
			'octillion',
			'nonillion',
			'decillion'
		];

		if ((strlen($num) === 4) AND ($num{1} !== '0') AND ($force_hundreds)) {
			$parts[0] = substr($num, 0, 2);
			$parts[1] = substr($num, 2, 2);

			return self::intToEnglish($parts[0]) . ' ' . $labels[0] . ' ' . self::intToEnglish($parts[1]);
		}

		$english = '';
		if (strlen($num) <= 2) {
			switch ($num) {
				case '0':
					$english = 'zero';
					break;
				case '1':
					$english = 'one';
					break;
				case '2':
					$english = 'two';
					break;
				case '3':
					$english = 'three';
					break;
				case '4':
					$english = 'four';
					break;
				case '5':
					$english = 'five';
					break;
				case '6':
					$english = 'six';
					break;
				case '7':
					$english = 'seven';
					break;
				case '8':
					$english = 'eight';
					break;
				case '9':
					$english = 'nine';
					break;
				case '10':
					$english = 'ten';
					break;
				case '11':
					$english = 'eleven';
					break;
				case '12':
					$english = 'twelve';
					break;
				case '13':
					$english = 'thirteen';
					break;
				case '14':
					$english = 'fourteen';
					break;
				case '15':
					$english = 'fifteen';
					break;
				case '16':
					$english = 'sixteen';
					break;
				case '17':
					$english = 'seventeen';
					break;
				case '18':
					$english = 'eighteen';
					break;
				case '19':
					$english = 'nineteen';
					break;
				default:
					switch ($num{0}) {
						case '2':
							$english = 'twenty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '3':
							$english = 'thirty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '4':
							$english = 'forty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '5':
							$english = 'fifty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '6':
							$english = 'sixty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '7':
							$english = 'seventy';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '8':
							$english = 'eighty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
						case '9':
							$english = 'ninty';
							if ($num{1}) {
								$english .= '-' . self::intToEnglish($num{1});
							}
							break;
					}
					break;
			}
		} else {
			$reverse = strrev($num);
			$strlen = strlen($reverse);
			$parts = [];

			$n = 0;
			while ($n < $strlen) {
				$parts[] = strrev(substr($reverse, $n, 3));
				$n += 3;
			}

			$i = 0;
			foreach ($parts AS $part) {
				$part = (int)$part;

				if ($part > 0) {
					if ($part < 100) {
						$temp = self::intToEnglish($part);
					} elseif ((int)substr($part, 1, 2) > 0) {
						$temp = self::intToEnglish(substr($part, 0, 1)) . ' ' . $labels[0] . ' ' . self::intToEnglish(substr($part,
								1, 2));
					} else {
						$temp = self::intToEnglish($part{0}) . ' ' . $labels[0];
					}

					if ($i > 0) {
						$english = $temp . ' ' . $labels[$i] . ' ' . $english;
					} else {
						$english = $temp;
					}
				}

				unset($temp);
				$english = trim($english);
				$i++;
			}
		}

		return $english;
	}

	/**
	 * Returns the roman numeral representation of an arabic integer
	 *
	 * @param int $int
	 * @return string
	 */
	public static function intToRoman($int): string
	{
		$num = trim($int);

		$first_chunk = substr($num, 0, -3);
		$roman = str_repeat('M', $first_chunk);

		$second_chunk = substr($num, -3);
		$second_chunk = str_repeat('0', (3 - strlen($second_chunk))) . $second_chunk;

		// THIRD-TO-LAST DIGIT
		switch ($second_chunk{0}) {
			case '1':
				$roman .= 'C';
				break;
			case '2':
				$roman .= 'CC';
				break;
			case '3':
				$roman .= 'CCC';
				break;
			case '4':
				$roman .= 'CD';
				break;
			case '5':
				$roman .= 'D';
				break;
			case '6':
				$roman .= 'DC';
				break;
			case '7':
				$roman .= 'DCC';
				break;
			case '8':
				$roman .= 'DCCC';
				break;
			case '9':
				$roman .= 'CM';
				break;
		}

		// SECOND-TO-LAST DIGIT
		switch ($second_chunk{1}) {
			case '1':
				$roman .= 'X';
				break;
			case '2':
				$roman .= 'XX';
				break;
			case '3':
				$roman .= 'XXX';
				break;
			case '4':
				$roman .= 'XL';
				break;
			case '5':
				$roman .= 'L';
				break;
			case '6':
				$roman .= 'LX';
				break;
			case '7':
				$roman .= 'LXX';
				break;
			case '8':
				$roman .= 'LXXX';
				break;
			case '9':
				$roman .= 'XC';
				break;
		}

		// LAST DIGIT
		switch ($second_chunk{2}) {
			case '1':
				$roman .= 'I';
				break;
			case '2':
				$roman .= 'II';
				break;
			case '3':
				$roman .= 'III';
				break;
			case '4':
				$roman .= 'IV';
				break;
			case '5':
				$roman .= 'V';
				break;
			case '6':
				$roman .= 'VI';
				break;
			case '7':
				$roman .= 'VII';
				break;
			case '8':
				$roman .= 'VIII';
				break;
			case '9':
				$roman .= 'IX';
				break;
		}

		if ($int < 1) {
			$roman = 'N';
		}

		return $roman;
	}
}
