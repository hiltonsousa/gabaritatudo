#!/usr/bin/env python3
"""
Lightweight Directory Tree Printer with Excludes
"""

import os
from pathlib import Path
from typing import List, Set, Iterator, Tuple


def walk_directory(
    root: str, 
    exclude_dirs: Set[str] = None, 
    show_hidden: bool = False
) -> Iterator[Tuple[Path, int, bool]]:
    """
    Generator that yields (path, depth, is_last) for directory tree traversal.
    
    Args:
        root: Root directory path
        exclude_dirs: Set of directory names to exclude
        show_hidden: Whether to show hidden files/directories
        
    Yields:
        Tuples of (path, depth, is_last_item_at_this_depth)
    """
    exclude_dirs = exclude_dirs or set()
    root_path = Path(root)
    
    if not root_path.is_dir():
        return
    
    # Sort directories first, then files
    def get_items(path: Path) -> List[Path]:
        items = []
        try:
            for item in path.iterdir():
                if not show_hidden and item.name.startswith('.'):
                    continue
                if item.is_dir() and item.name in exclude_dirs:
                    continue
                items.append(item)
        except PermissionError:
            return []
        
        # Sort: directories first, then files (both alphabetically)
        dirs = sorted([i for i in items if i.is_dir()], key=lambda x: x.name.lower())
        files = sorted([i for i in items if i.is_file()], key=lambda x: x.name.lower())
        return dirs + files
    
    def _walk(path: Path, depth: int, prefix: str):
        items = get_items(path)
        
        for idx, item in enumerate(items):
            is_last = (idx == len(items) - 1)
            connector = "└── " if is_last else "├── "
            
            if item.is_dir():
                print(f"{prefix}{connector}{item.name}/")
                extension = "    " if is_last else "│   "
                _walk(item, depth + 1, prefix + extension)
            else:
                size = item.stat().st_size if item.is_file() else 0
                size_str = f" ({size} B)" if size < 1024 else f" ({size/1024:.1f} KB)"
                print(f"{prefix}{connector}{item.name}{size_str}")
    
    print(f"{root_path.name}/")
    _walk(root_path, 0, "")


def print_tree(
    directory: str, 
    exclude: List[str] = None, 
    show_hidden: bool = False
) -> None:
    """
    Print a formatted directory tree.
    
    Args:
        directory: Root directory path
        exclude: List of directory names to exclude
        show_hidden: Whether to show hidden files/directories
    """
    walk_directory(directory, set(exclude) if exclude else None, show_hidden)


if __name__ == "__main__":
    # Example usage
    import sys
    
    if len(sys.argv) > 1:
        directory = sys.argv[1]
        exclude = sys.argv[2:] if len(sys.argv) > 2 else []
        print_tree(directory, exclude=exclude)
    else:
        # Demo: print current directory tree excluding common directories
        print("Current directory tree:")
        print("-" * 60)
        print_tree(".", exclude=["__pycache__", ".git", ".github", "venv", ".venv", "src"])