import * as Typography from '#/icons/Typography'
import { Tooltip } from '#/modules/Tooltip'
import { IconBtn } from '@/Buttons/IconBtn'
import { MarkdownBtn } from '@/Buttons/MarkdownBtn'

import style from './markdownBar.module.scss'

type Props = {
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const MarkdownBar: React.FC<Props> = ({ onClick }) => {
    return (
        <fieldset className={style.markdownBar}>
            <Tooltip content="Bold">
                <MarkdownBtn name="bold" Icon={Typography.Bold} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Italic">
                <MarkdownBtn name="italic" Icon={Typography.Italic} onClick={onClick} />
            </Tooltip>
            <Tooltip content="URL">
                <MarkdownBtn name="link" Icon={Typography.Link} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Ordered List">
                <MarkdownBtn name="ordered-list" Icon={Typography.OrderedList} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Unordered List">
                <MarkdownBtn
                    name="unordered-list"
                    Icon={Typography.UnorderedList}
                    onClick={onClick}
                />
            </Tooltip>
            <Tooltip content="Heading">
                <MarkdownBtn name="heading" Icon={Typography.Heading} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Quote">
                <MarkdownBtn name="quote" Icon={Typography.Quote} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Code">
                <MarkdownBtn name="code" Icon={Typography.Code} onClick={onClick} />
            </Tooltip>
            <Tooltip content="Codeblock">
                <MarkdownBtn name="codeblock" Icon={Typography.CodeBlock} onClick={onClick} />
            </Tooltip>
            <Tooltip content="File">
                <MarkdownBtn name="file" Icon={Typography.Attach} onClick={onClick} />
            </Tooltip>
            <IconBtn name="markdown" Icon={Typography.Markdown} onClick={onClick} />
        </fieldset>
    )
}
