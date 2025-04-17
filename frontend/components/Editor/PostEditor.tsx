import Markdown from 'markdown-to-jsx'
import { useRouter } from 'next/router'
import { useRef, useState } from 'react'
import AsyncSelect from 'react-select/async'
import ReactTextareaAutosize from 'react-textarea-autosize'

import { SelectableBtn } from '@/Buttons/SelectableBtn'
import { NewPostSettingsDropdown } from '@/Dropdowns/NewPostSettingsDropdown'
import { InputSubmit } from '@/Inputs/InputSubmit'
import { MarkdownBar } from '@/Markdown/MarkdownBar'

import { client } from '#/lib/fetch'
import { markdownHandler } from '#/lib/markdown'
import { tagStyles } from '#/lib/react-select'
import { useToast } from '#/modules/Toaster'

import style from './postEditor.module.scss'

type Mode = 'preview' | 'edit'
type Props = {
    readonly post?: Post
}

export const PostEditor: React.FC<Props> = ({ post }) => {
    const [mode, setMode] = useState<Mode>('edit')
    const [title, setTitle] = useState(post?.title || '')
    const [tags, setTags] = useState(post?.tags || [])
    const [content, setContent] = useState(post?.content || '')
    const parentState = useState(post?.parent || null)

    const { promise } = useToast()
    const router = useRouter()
    const contentRef = useRef<HTMLTextAreaElement>(null)

    const handleModeChange: React.MouseEventHandler<HTMLButtonElement> = ({ currentTarget }) => {
        setMode(currentTarget.name as Mode)
    }

    const handleMarkdown: React.MouseEventHandler<HTMLButtonElement> = ({ currentTarget }) => {
        const pStart = contentRef.current?.selectionStart ?? 0
        const pEnd = contentRef.current?.selectionEnd ?? 0

        const result = markdownHandler(
            currentTarget.name as MarkdownType,
            contentRef.current?.value.substring(pStart, pEnd)
        )

        if (pStart !== 0 || pEnd !== pStart) {
            setContent(content.slice(0, pStart) + result + content.slice(pEnd))
        } else setContent(content + result)
    }

    const handleSubmit: React.FormEventHandler<HTMLFormElement> = async e => {
        e.preventDefault()
        promise({
            title: 'Creating...',
            promise: client.post<Post>('/posts', {
                title: title,
                content: content,
                tag_ids: tags.map(tag => tag.id),
                parent_id: parentState[0]?.id,
            }),
            onSuccess: data => router.push(`/p/${data.id}`),
        })
    }

    const loadTags = async (search: string) =>
        new Promise<Tag[]>(async resolve => {
            const tags = await client.get<Tag[]>(`/tags?search=${search}`)
            resolve(tags.data.map(tag => ({ ...tag, label: tag.name, value: tag.id })))
        })

    return (
        <div className={style.container}>
            <fieldset className={style.modes}>
                <SelectableBtn name="edit" selected={mode === 'edit'} onClick={handleModeChange} />
                <SelectableBtn
                    name="preview"
                    selected={mode === 'preview'}
                    onClick={handleModeChange}
                />
            </fieldset>
            <form className={style.form} onSubmit={handleSubmit}>
                <section className={style.editor}>
                    <ReactTextareaAutosize
                        cacheMeasurements
                        value={title}
                        onChange={e => setTitle(e.target.value)}
                        placeholder="New post title ..."
                        className={style.title}
                        autoComplete="off"
                        maxLength={64}
                        disabled={mode === 'preview'}
                        aria-label="Post title"
                        data-gramm_editor="false"
                        required
                        autoFocus
                    />
                    <AsyncSelect
                        isMulti
                        cacheOptions
                        id="tags"
                        instanceId="tags"
                        aria-label="tags"
                        placeholder="Search for tags ..."
                        className={style.tags}
                        styles={tagStyles}
                        value={tags}
                        isDisabled={mode === 'preview'}
                        isOptionDisabled={() => tags.length >= 5}
                        onChange={tags => setTags(tags as Tag[])}
                        loadOptions={loadTags}
                    />
                    {mode === 'edit' ? (
                        <>
                            <MarkdownBar onClick={handleMarkdown} />
                            <ReactTextareaAutosize
                                cacheMeasurements
                                value={content}
                                ref={contentRef}
                                minRows={1}
                                onChange={e => setContent(e.target.value)}
                                placeholder="Post content ..."
                                className={style.content}
                                autoComplete="off"
                                maxLength={65535}
                                aria-label="Post content"
                                required
                            />
                        </>
                    ) : (
                        <Markdown className={style.preview}>{content}</Markdown>
                    )}
                </section>
                <fieldset className={style.options}>
                    <InputSubmit
                        style={{
                            width: 'fit-content',
                            background: '#515ddd',
                        }}
                        label="Publish"
                    />
                    <NewPostSettingsDropdown parentState={parentState} />
                </fieldset>
            </form>
        </div>
    )
}
