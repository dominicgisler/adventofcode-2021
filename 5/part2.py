import collections
import itertools
from functools import reduce
from itertools import chain
from pathlib import Path


def range_lower_or_higher(x1, x2):
    return chain(range(x1, x2 + 1), range(x2, x1 + 1))

def range_diagonal(x1y1, x2y2):
    direction_mask = [0,0]
    direction_mask[0] = int(x1y1[0] < x2y2[0]) or -1
    direction_mask[1] = int(x1y1[1] < x2y2[1]) or -1
    range_points = [x1y1]
    while range_points[-1] != x2y2:
        range_points.append(list(map(sum, zip(range_points[-1], direction_mask))))
    return range_points

def get_points(file: Path):
    raw_lines = file.read_text().splitlines()
    coordinates = list(map(lambda xy: list(map(lambda x: list(map(int, x.split(','))), xy.split(' -> '))), raw_lines))
    horizontal_lines = list(filter(lambda c: c[0][0] == c[1][0], coordinates))
    vertical_lines = list(filter(lambda c: c[0][1] == c[1][1], coordinates))
    diagonal_lines = list(filter(lambda c: c not in chain(horizontal_lines, vertical_lines), coordinates))
    horizontal_points = [[line[0][0], cor] for line in horizontal_lines for cor in range_lower_or_higher(line[0][1], line[1][1])]
    vertical_points = [[cor, line[0][1]] for line in vertical_lines for cor in range_lower_or_higher(line[0][0], line[1][0])]
    diagonal_points = list(itertools.chain(*[range_diagonal(line[0],line[1]) for line in diagonal_lines]))
    return horizontal_points + vertical_points + diagonal_points


def reducer(acc, val):
    if tuple(val) in acc:
        acc[tuple(val)] += 1
    else:
        acc[tuple(val)] = 1
    return acc


def calculate_overlapping_points(points):
    more_than_once = list(filter(lambda d: d[1] > 1, reduce(reducer, points, collections.defaultdict()).items()))
    return len(more_than_once)


if __name__ == '__main__':
    print(calculate_overlapping_points(get_points(Path('5.txt'))))
    # 18674
