import { createContext, useContext, useEffect, useRef, useState } from 'react'
import { createPortal } from 'react-dom'

import { Loading, Success, Warning } from '#/icons/Toast'
import style from './index.module.scss'

type Toast = {
    loading: (message?: string) => void
    success: (message?: string) => void
    error: (message?: string) => void
    promise: (params: {
        promise: Promise<any>
        title?: string
        onSuccess?: (res: any) => void
        onError?: (err: any) => void
    }) => void
    clear: () => void
}

const ProviderContext = createContext<Toast>(null!)
export const useToast = () => useContext(ProviderContext)

export const ToastProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
    const [rendered, setRendered] = useState(false)
    const [title, setTitle] = useState('')
    const [icon, setIcon] = useState<any>(null)
    const [mounted, setMounted] = useState(false)
    const ref = useRef<HTMLDivElement>(null)

    useEffect(() => {
        setMounted(true)
        return () => setMounted(false)
    }, [])

    const promise: Toast['promise'] = ({ promise, title, onSuccess, onError }) => {
        setTitle(title ? title : 'Processing...')
        setIcon(<Loading className={style.spinAnimation} />)
        setRendered(true)
        promise
            .then(res => {
                success(res.message)
                onSuccess && onSuccess(res)
            })
            .catch(err => {
                error(err.name === 'SyntaxError' ? 'Server offline' : err.message)
                onError && onError(err)
            })
    }

    const loading: Toast['loading'] = message => {
        message ? setTitle(message) : setTitle('Processing...')
        setIcon(<Loading className={style.spinAnimation} />)
        setRendered(true)
    }

    const success: Toast['success'] = message => {
        message ? setTitle(message) : setTitle('Success')
        setIcon(<Success />)
        setRendered(true)
        setTimeout(clear, 5000)
    }

    const error: Toast['error'] = message => {
        if (!message) setTitle('Something went wrong')
        else
            setTitle(
                Array.isArray(message)
                    ? () => {
                          let mergedMsg = ''
                          message.forEach((object: any) => {
                              for (const key in object) {
                                  const value = object[key]
                                  mergedMsg = `${mergedMsg}\n${key}:${value}`
                              }
                          })
                          return mergedMsg.trim()
                      }
                    : message
            )
        setIcon(<Warning />)
        setRendered(true)
        setTimeout(clear, 5000)
    }

    const clear: Toast['clear'] = () => {
        if (!ref.current) return
        ref.current.className = `${style.toast} ${style.popDownAnimation}`
        ref.current.onanimationend = () => setRendered(false)
    }

    return (
        <>
            <ProviderContext.Provider
                value={{
                    loading,
                    success,
                    error,
                    promise,
                    clear,
                }}
            >
                {children}
            </ProviderContext.Provider>
            {mounted &&
                createPortal(
                    rendered && (
                        <div className={style.toastContainer} data-cy="toaster">
                            <div className={style.toast} ref={ref}>
                                {icon}
                                <span>{title}</span>
                            </div>
                        </div>
                    ),
                    document.getElementById('__next')!
                )}
        </>
    )
}
